<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Question;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\ChangePicRequest;
use App\Http\Requests\EnrollmentSubmitRequest;
use App\Http\Requests\StudentStoreRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStoreRequest $request)
    {
        if(!Student::storeEvaluate($request->all()))
            return back()->with('message', 'Error in submitting evaluation.');

        return redirect('/student')->with('message', 'Evaluation submitted.');
    }

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
        $name = Hash::make($student->id) . '.' . $request->file('imgPath')->getClientOriginalExtension();
        $request->file('imgPath')->storeAs('public/images', $name);
        //update img
        $student->imgPath = $name;

        if(!$student->save())
            return redirect(route('student.profile'))->with('message', 'Error in updating profile. Please try again.');

        return redirect(route('student.profile'))->with('message', 'Profile picture updated.');
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
            return redirect(route('student.profile'))->with('message', 'Error in updating profile. Please try again');

        return redirect(route('student.profile'))->with('message', 'Profile updated.');
    }

    public function evaluate()
    {
        $question = Question::where('type', 4)
                            -> orderBy('q_type_id')
                            -> orderBy('q_category_id')
                            -> get();
        $instructor = Faculty::all();

        return view('student.evaluate', compact('question', 'instructor'));
    }

    public function changePeriod(Request $request)
    {
        $request->session()->put('period', (int) $request->period);

        return back()->with('message', 'Period changed.');
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
