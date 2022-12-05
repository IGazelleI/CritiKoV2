<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\Department;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePicRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\FacultyStoreRequest;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('faculty.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $det = Faculty::with('user')
                    -> where('user_id', '=', auth()->user()->id)
                    -> get()
                    -> first();

        return view('faculty.profile', compact('det'));
    }

    public function update(FacultyStoreRequest $request)
    {
        if(!Faculty::updateInfo($request->all()))
            return back()->with('message', 'Error in updating profile. Please try again');

        return back()->with('message', 'Profile updated.');
    }

    public function changeProfilePicture(ChangePicRequest $request, Faculty $faculty)
    {
        $name = encrypt($faculty->id) . '.' . $request->file('imgPath')->getClientOriginalExtension();
        $request->file('imgPath')->storeAs('public/images', $name);
        //update img
        $faculty->imgPath = $name;

        if(!$faculty->save())
            return back()->with('message', 'Error in updating profile. Please try again.');

        return back()->with('message', 'Profile picture updated.');
    }

    public function changePeriod(Request $request)
    {
        $request->session()->put('period', (int) $request->period);

        return back()->with('message', 'Period changed.');
    }

    public function enrollment()
    {
        $courses = Department::find(auth()->user()->faculties[0]->department_id)
                                -> courses;
        
        $enrollment = new Collection;
        $i = 0;

        foreach($courses as $det)
        {
            $enrolls = $det->enrollments
                        -> where('status', '=', 'Pending')
                        -> where('period_id', Session::get('period'));
            foreach($enrolls  as $cat)
            {
                $enrollment[$i] = $cat;
                $i += 1;
            }
        }

        return view('dean.enrollment', compact('enrollment'));
    }

    public function processEnrollment(Request $request, Enrollment $enroll)
    {
        $status = $request->decision? 'Approved' : 'Denied';

        if(!DB::table('enrollments')
            -> where('id', $enroll->id)
            -> update(['status' => $status])
        )
            return back()->with('message', 'Error in updating enrollment.');

        if(!Enrollment::process($request->all(), $enroll))
        {
            if(!DB::table('enrollments')
                -> where('id', '=', $enroll->id)
                -> update(['status' => 'Pending'])
            )
                return back()->with('message', 'Error in updating enrollment.');
        }

        return back()->with('message', 'Enrollment ' . $status . '.');
    }

    public function evaluate(Request $request)
    {
        $period = Period::find(Session::get('period'));

        $question = Question::where('type', 4)
                        -> orderBy('q_type_id')
                        -> orderBy('q_category_id')
                        -> get();

        $faculty = Faculty::where('department_id', auth()->user()->faculties[0]->department_id)
                        -> where('user_id', '!=', auth()->user()->id)
                        -> latest('id')
                        -> get();

        if(isset($request->faculty))
            $request->session()->put('selected', (int) decrypt($request->faculty));

        $currentSelected = Session::get('selected');

        $evaluation = $currentSelected != null? Evaluate::where('evaluator', auth()->user()->id)
                                                        -> where('evaluatee', $currentSelected)
                                                        -> where('period_id', Session::get('period'))
                                                        -> latest('id')
                                                        -> get()
                                                        -> first() : null;

        return view('faculty.evaluate', compact('period', 'question', 'faculty'));
    }

    public function evaluateProcess(Request $request)
    {
        if(!Faculty::storeEvaluate($request->all()))
            return back()->with('message', 'Error in submitting evaluation.');

        return redirect(route('faculty.evaluate'))->with('message', 'Evaluation submitted.');
    }

    public function changeSelected(Request $request)
    {
        $request->session()->put('selected', (int) $request->user_id);

        return redirect(route('faculty.evaluate'))->with('message', 'Selected changed.');
    }
}
