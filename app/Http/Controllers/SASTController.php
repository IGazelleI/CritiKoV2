<?php

namespace App\Http\Controllers;

use App\Models\Sast;
use App\Models\Course;
use App\Models\Period;
use App\Models\Department;
use App\Models\Evaluate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SASTController extends Controller
{
    public function show()
    {
        $det = Sast::with('user')->where('user_id', '=', auth()->user()->id)->first();

        return view('sast.profile', compact('det'));
    }

    public function facultyReport()
    {
        $period = Session::get('period') != null? Period::find(Session::get('period')) : Period::latest('id')->get()->first()->id;
        $department = Department::with('faculties')
                            -> latest('id')
                            -> get();
        
        $evaluation = Evaluate::where('period_id', $period->id)
                            -> latest('id')
                            -> get(); 

        return view('sast.facultyReport', compact('period', 'department', 'evaluation'));
    }

    public function studentReport()
    {
        $period = Session::get('period') != null? Session::get('period') : Period::latest('id')->get()->first()->id;

        $courses = Course::with('enrollments')
                    -> latest('id')
                    -> get();

        return view('sast.studentReport', compact('courses', 'period'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!Sast::updateInfo($request->all()))
            return back()->with('message', 'Error in updating profile. Please try again');

        return back()->with('message', 'Profile updated.');
    }

    public function changePeriod(Request $request)
    {
        $request->session()->put('period', (int) $request->period);

        return back()->with('message', 'Period changed.');
    }

    public function setEvaluationDate(Request $request)
    {
        if((isset($request->beginEval) && !isset($request->endEval)) || (!isset($request->beginEval) && isset($request->endEval)))
            return back()->with('message', 'It is recommended set both dates instead of just only one.');
        
        $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));

        if(!$period->update([
            'beginEval' => $request->beginEval,
            'endEval' => $request->endEval
        ]))
            return back()->with('message', 'Error in updating evaluation data. Please try again.');

        return back()->with('message', ' Evaluation date set.');
    }
}