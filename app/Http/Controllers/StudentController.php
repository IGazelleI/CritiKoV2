<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Question;
use App\Models\Period;
use App\Models\Enrollment;
use App\Models\Evaluate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ChangePicRequest;
use App\Http\Requests\EnrollmentSubmitRequest;
use App\Http\Requests\StudentStoreRequest;

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
        $det = Student::with('user')->where('user_id', '=', auth()->user()->id)->first();

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

    public function evaluate()
    {
        $period = Period::find(Session::get('period'));

        $enrollment = Enrollment::where('user_id', auth()->user()->id)
                            -> where('period_id', $period->id)
                            -> latest('id')
                            -> get()
                            -> first();
        
        $question = Question::where('type', 4)
                        -> orderBy('q_type_id')
                        -> orderBy('q_category_id')
                        -> get();

        $instructor = isset($enrollment)? Faculty::join('klases', 'faculties.user_id', 'klases.instructor')
                                            -> join('blocks', 'klases.block_id', 'blocks.id')
                                            -> where('faculties.department_id', auth()->user()->students[0]->enrollments[0]->course->department_id)
                                            -> latest('faculties.user_id')
                                            -> get() : null;

        $currentSelected = Session::get('selected');

        $evaluation = $currentSelected != null? Evaluate::where('evaluator', auth()->user()->id)
                                                        -> where('evaluatee', $currentSelected)
                                                        -> where('period_id', Session::get('period'))
                                                        -> latest('id')
                                                        -> get()
                                                        -> first() : null;

        return view('student.evaluate', compact('enrollment', 'period', 'instructor', 'question', 'evaluation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        $request->session()->put('selected', (int) $request->user_id);

        return back()->with('message', 'Selected changed.');
    }

    public function enrollment(Request $request)
    {
        $enrollment = Enrollment::where('user_id', auth()->user()->id)
                            -> where('period_id', Session::get('period'))
                            -> get()
                            -> first();
        
        $det = Student::where('user_id', auth()->user()->students[0]->user_id)
                    -> get()
                    -> first();

        $course = Course::orderBy('name')->get();

        return view('student.enrollment', compact('det', 'course', 'enrollment'));
    }

    public function enroll(EnrollmentSubmitRequest $request)
    {
        if(!Enrollment::create([
            'user_id' => auth()->user()->id,
            'period_id' => Session::get('period'),
            'course_id' => $request->course_id,
            'year_level' => $request->year_level,
            'status' => 'Pending'
        ]))
            return back()->with('message', 'Error in submitting enrollment. Please try again.');

        return back()->with('message', 'Enrollment submitted. Stay tuned for the process.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
