<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Period;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Imports\CoursesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\CourseStoreRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($department = null)
    {
        $course = Course::where(function ($query) use ($department)
                        {
                            if($department != null)
                                $query->where('department_id', $department);
                        })
                        -> latest('id')
                        -> get();

        $department = ($department != 0)? Department::find($department) : null;
                    
        return view('course.index', compact('course', 'department'));
    }

    public function import()
    {
        Excel::import(new CoursesImport,request()->file('file'));

        return back()->with('message', 'Courses imported successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request)
    {
        if(!Course::create([
            'department_id' => $request->department_id,
            'name' => $request->name,
            'description' => $request->description
        ]))
            return back()->with('message', 'Error in adding course. Please try again');

        return back()->with('message', 'Course added.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseStoreRequest $request)
    {
        $course = Course::find($request->id);

        if(!$course->update([
            'department_id' => $request->department_id,
            'name' => $request->name,
            'description' => $request->description
        ]))
            return back()->with('message', 'Error in updating course. Please try again.');

        return back()->with('message', 'Course updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $course = Course::find($request->id);

        if(!$course->delete())
            return back()->with('message', 'Error in deleting course. Please try again.');

        return back()->with('message', 'Course deleted.');
    }
}
