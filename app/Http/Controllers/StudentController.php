<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $question = Question::all();
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
        $det = Student::where('user_id', auth()->user()->students[0]->user_id)
                    -> get()
                    -> first();
        $course = Course::orderBy('name')->get();
        
        return view('student.enrollment', compact('det', 'course'));
    }

    public function enroll(EnrollmentSubmitRequest $request)
    {

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
