<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Course;
use App\Models\Period;
use App\Models\Enrollment;
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
            return back()->with('message', 'Error in adding block. Please try again');

        return back()->with('message', 'Block added.');
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
            return back()->with('message', 'Error in updating block. Please try again.');

        return back()->with('message', 'Block updated.');
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
        $period = $block->period_id;

        //delete the block students
        if(!$block->blockStudents->isEmpty())
        {
            foreach($block->blockStudents as $blockStud)
            {
                if(!$blockStud->delete())
                    return back()->with('message', 'Error in deleting block students. Please try again.');
            }
        }
        //delete block classes
        foreach($block->klases as $klase)
        {
            if(!$klase->klaseStudents->isEmpty())
            {
                foreach($klase->klaseStudents as $klaseStud)
                {
                    //delete enrollment from those students
                    $enroll = Enrollment::where('period_id', $klaseStud->klase->block->period_id)
                                        -> where('user_id', $klaseStud->user_id)
                                        -> get()
                                        -> first();
                    
                    if($enroll != null)
                    {
                        if(!$enroll->delete())
                            return back()->with('message', 'Error in deleting enrollment from that block classes. Please try again.');
                    }

                    if(!$klaseStud->delete())
                        return back()->with('message', 'Error in deleting block class students. Please try again.');
                }
            }

            if(!$klase->delete())
                return back()->with('message', 'Error in deleting block classes. Please try again.');
        }

        if(!$block->delete())
            return back()->with('message', 'Error in deleting block. Please try again.');

        return redirect(route('block.manage', $period))->with('message', 'Block deleted.');
    }
}
