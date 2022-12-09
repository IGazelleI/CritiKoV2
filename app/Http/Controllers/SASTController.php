<?php

namespace App\Http\Controllers;

use App\Models\Sast;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SASTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sast.index');
    }

    public function show()
    {
        $det = Sast::with('user')->where('user_id', '=', auth()->user()->id)->first();

        return view('sast.profile', compact('det'));
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
        $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));

        if(!$period->update([
            'beginEval' => $request->beginEval,
            'endEval' => $request->endEval
        ]))
            return back()->with('message', 'Error in updating evaluation data. Please try again.');

        return back()->with('message', ' Evaluation date set.');
    }
}