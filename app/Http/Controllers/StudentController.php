<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\QCategory;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePicRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\EnrollmentSubmitRequest;
use App\Models\EnrollmentDetail;
use App\Models\EnrollmentSubject;
use App\Models\KlaseStudent;

class StudentController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $det = Student::with('user')
                    -> where('user_id', '=', auth()->user()->id)
                    -> get()
                    -> first();

        return view('student.profile', compact('det'));
    }

    /**
     * Change profile picture.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeProfilePicture(ChangePicRequest $request, Student $student)
    {
        $name = encrypt($student->id) . '.' . $request->file('imgPath')->getClientOriginalExtension();
        $request->file('imgPath')->storeAs('public/images', $name);
        //update img
        $student->imgPath = $name;

        if(!$student->save())
            return back()->with('message', 'Error in updating profile. Please try again.');

        return back()->with('message', 'Profile picture updated.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentStoreRequest $request)
    {
        if(!Student::updateInfo($request->all()))
            return back()->with('message', 'Error in updating profile. Please try again');

        return back()->with('message', 'Profile updated.');
    }

    public function evaluate(Request $request)
    {
        $period = Period::find(Session::get('period'));

        $enrollment = Enrollment::where('user_id', auth()->user()->id)
                            -> where('period_id', $period->id)
                            -> latest('id')
                            -> get()
                            -> first();
        
        $cat = QCategory::where('type', 4)
                    -> latest('id')
                    -> get();

        $question = new Collection();
        
        foreach($cat as $det)
        {
            foreach($det->questions as $q)
                $question->push($q);
        }
        //sort the questions by type
        $question = $question->sortBy('q_type_id');

        $subjects =  isset($enrollment)? KlaseStudent::with('klase')
                                                    -> where('user_id', auth()->user()->id)       
                                                    -> latest('id')
                                                    -> get() : null;

        if(isset($request->subject))
            $request->session()->put('selected', (int) decrypt($request->subject));
        
        $currentSelected = Session::get('selected');
        $subject_id = $currentSelected == null? null : $subjects->find($currentSelected)->klase->subject_id;
        //get the evaluations from the selected 
        $evaluation = $currentSelected != null? Evaluate::where('evaluator', auth()->user()->id)
                                                        -> where('evaluatee', $subjects->find($currentSelected)->klase->instructor)
                                                        -> where('subject_id', $subject_id)
                                                        -> where('period_id', Session::get('period'))
                                                        -> latest('id')
                                                        -> get()
                                                        -> first() : null;

        return view('student.evaluate', compact('enrollment', 'period', 'subjects', 'question', 'evaluation', 'subject_id'));
    }

    public function evaluateProcess(Request $request)
    {
        if(!Student::storeEvaluate($request->all()))
            return back()->with('message', 'Error in submitting evaluation.');

        return redirect(route('student.evaluate'))->with('message', 'Evaluation submitted.');
    }

    public function changePeriod(Request $request)
    {
        $request->session()->put('period', (int) $request->period);

        return back()->with('message', 'Period changed.');
    }

    public function changeSelected(Request $request)
    {
        $request->session()->put('selected', (int) $request->subject);

        return redirect(route('student.evaluate'))->with('message', 'Selected changed.');
    }

    public function enrollment(Request $request)
    {
        //get period selected
        $period = Period::find(Session::get('period'));
        //get enrollment type
        $enrollType = Session::get('enrollType');
        //get course
        $courseSelected = Session::get('course');
        //get year
        $yearSelected = Session::get('year');

        $enrollment = Enrollment::where('user_id', auth()->user()->id)
                            -> where('period_id', Session::get('period'))
                            -> get()
                            -> first(); 
        
        if(isset($enrollment))
        {
            $enrollType = $enrollment->type;
            $courseSelected = $enrollment->course_id;
            $yearSelected = $enrollment->year_level;
        }
        //get all available courses
        $course = Course::orderBy('name')->get();

        $variables = ['period', 'course', 'enrollment', 'enrollType', 'courseSelected', 'yearSelected'];
        //get subjects from selection when irregular
        if($enrollType == 1)
        {
            $subjects = Subject::where('semester', $period->semester)
                            -> where('course_id', isset($enrollment)? $enrollment->course_id : $courseSelected)
                            -> where('year_level', isset($enrollment)? $enrollment->year_level : $yearSelected)
                            -> latest('id')
                            -> get();

            $variables = array_merge($variables, ['subjects']);

            if(isset($enrollment))
            {
                $subjectsTaken = EnrollmentDetail::with('enrollSubjects')
                                            -> where('enrollment_id', $enrollment->id)
                                            -> latest('id')
                                            -> get()
                                            -> first()
                                            -> enrollSubjects;

                $variables = array_merge($variables, ['subjectsTaken']);
            }
        }

        return view('student.enrollment', compact($variables));
    }

    public function changeEnrollType(Request $request)
    {
        $request->session()->put('enrollType', (int) $request->type);

        return back()->with('message', 'Enrollment type changed.');
    }

    public function changeCourse(Request $request)
    {
        $request->session()->put('course', (int) $request->course_id);

        return back()->with('message', 'Course changed.');
    }

    public function changeYear(Request $request)
    {
        $request->session()->put('year', (int) $request->year_level);

        return back()->with('message', 'Year level changed.');
    }

    public function enroll(Request $request)
    {
        $enrollType = Session::get('enrollType');

        if($enrollType == 0)
        {
            if(Subject::where('semester', Period::find(Session::get('period'))->semester)
                            -> where('course_id', Session::get('course'))
                            -> where('year_level', Session::get('year'))
                            -> latest('id')
                            -> get()
                            -> count() == 0)
                return back()->with('message', 'Course selected has no subjects. Please try again tommorow.');            
        }

        $enrollment = Enrollment::create([
            'type' => $enrollType,
            'user_id' => auth()->user()->id,
            'period_id' => Session::get('period'),
            'course_id' => Session::get('course'),
            'year_level' => Session::get('year'),
            'status' => 'Pending'
        ]);

        if(!$enrollment)
            return back()->with('message', 'Error in submitting enrollment. Please try again.');

        //irregular details
        if($enrollType == 1)
        {
            $enrollDetail = EnrollmentDetail::create(['enrollment_id' => $enrollment->id]);

            if(!$enrollDetail)
                return back()->with('message', 'Error in submitting enrollment detail. Please try again.');
            //subjects taken
            for($i = 0; $i < $request->subCount; $i++)
            {
                if(isset($request['subject_' . $i]))
                {
                    if(!EnrollmentSubject::create([
                        'enrollment_detail_id' => $enrollDetail->id,
                        'subject_id' => $request['subject_' . $i]
                    ]))
                        return back()->with('message', 'Error in creating enrollment subject. Please try again.');
                }
            }
        }

        return back()->with('message', 'Enrollment submitted. Stay tuned for the process.');
    }
}
