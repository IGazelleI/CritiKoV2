<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;
use App\Http\Requests\PeriodStoreRequest;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(PeriodStoreRequest $request)
    {
        if((isset($request->beginEnroll) && !isset($request->endEnroll)) || (!isset($request->beginEnroll) && isset($request->endEnroll)))
            return back()->with('message', 'It is recommended set both dates instead of just only one.');

        if((isset($request->beginEval) && !isset($request->endEval)) || (!isset($request->beginEval) && isset($request->endEval)))
            return back()->with('message', 'It is recommended set both dates instead of just only one.');

        if(!Period::create([
            'academic_year_id' => $request->acadYear,
            'semester' => $request->semester,
            'begin' => $request->begin,
            'end' => $request->end,
            'beginEnroll' => $request->beginEnroll,
            'endEnroll' => $request->endEnroll,
            'beginEval' => $request->beginEval,
            'endEval' => $request->endEval
            
        ]))
            return back()->with('message', 'Error in adding period. Please try again');

        return back()->with('message', 'Period added.');
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
        if((isset($request->beginEnroll) && !isset($request->endEnroll)) || (!isset($request->beginEnroll) && isset($request->endEnroll)))
            return back()->with('message', 'It is recommended set both dates instead of just only one.');

        if((isset($request->beginEval) && !isset($request->endEval)) || (!isset($request->beginEval) && isset($request->endEval)))
            return back()->with('message', 'It is recommended set both dates instead of just only one.');

        if(isset($request->beginEnroll))
        {
            $formFields = $request->validate([
                'endEnroll' => 'after:beginEnroll',
            ],
            [
                'endEnroll.after' => 'The end date of the enrollment cannot be the date before it starts.'
            ]);
        }

        if(isset($request->beginEval))
        {
            $formFields = $request->validate([
                'endEval' => 'after:beginEval',
            ],
            [
                'endEval.after' => 'The end date of the evaluation cannot be the date before it starts.'
            ]);
        }
        

        $period = Period::find($request->id);
        
        if(!$period->update([
            'semester' => $request->semester,
            'begin' => $request->begin,
            'end' => $request->end,
            'beginEnroll' => $request->beginEnroll,
            'endEnroll' => $request->endEnroll,
            'beginEval' => $request->beginEval,
            'endEval' => $request->endEval
        ]))
            return back()->with('message', 'Error in updating period. Please try again.');

        return back()->with('message', ' Period updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $period = Period::find($request->id);

        if(!$period->delete())
            return back()->with('message', 'Error in deleting period. Please try again.');
        
        return back()->with('message', 'Period deleted.');
    }
}
