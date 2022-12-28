<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Course;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BlockStoreRequest;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($period = null)
    {
        /* $block = Block::where(function ($query) use ($course)
                        {
                            if($course != null)
                                $query->where('course_id', $course);
                        })
                        -> groupBy('period_id', 'course_id', 'id', 'year_level', 'section', 'deleted_at', 'created_at', 'updated_at')
                        -> orderBy('period_id', 'desc')
                        -> get(); */

        /* $course = ($course != 0)? Course::find($course) : null; */

       /*  if(isset($course))
            return view('block.index', compact('block', 'course'));
        else
        {
            $courses = Course::latest('id')
                            -> get();

            return view('block.index', compact('block', 'course', 'courses'));
        } */

        $periods = Period::latest('id')
                        -> get();

        $period = (isset($period))? Period::find($period) : Period::latest('id')->get()->first();
        
        $block = Block::where(function ($query) use ($period)
                        {
                            if($period != null)
                                $query->where('period_id', $period->id);
                        })
                        -> orderBy('course_id')
                        -> get();

        return view('block.index', compact('period', 'periods', 'block'));
    }

    public function show(Period $period, Course $course, $year_level = null)
    {
        $periods = Period::latest('id')
                        -> get();
        
        $block = Block::where(function ($query) use ($year_level)
                        {
                            if($year_level != null)
                                $query->where('year_level', $year_level);
                        })
                        -> where('period_id', $period->id)
                        -> where('course_id', $course->id)
                        -> orderBy('year_level')
                        -> get();

        $year_level = ($year_level == null)? null : $block->first()->getYear();

        return view('block.show', compact('period', 'course', 'periods', 'block', 'year_level'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockStoreRequest $request)
    {
        if(!Block::create([
            'course_id' => $request->course_id,
            'period_id' => $request->period_id,
            'year_level' => $request->year_level,
            'section' => $request->section
        ]))
            return back()->with('danger', 'Error in adding block. Please try again');

        return back()->with('success', 'Block added.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlockStoreRequest $request)
    {
        $block = Block::find($request->id);

        if(!$block->update([
            'course_id' => $request->course_id,
            'period_id' => $request->period_id,
            'year_level' => $request->year_level,
            'section' => $request->section
        ]))
            return back()->with('danger', 'Error in updating block. Please try again.');

        return back()->with('success', 'Block updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $block = Block::find($request->id);

        if(!$block->delete())
            return back()->with('danger', 'Error in deleting block. Please try again.');

        return back()->with('success', 'Block deleted.');
    }
}
