<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentStoreRequest;

class DepartmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentStoreRequest $request)
    {
        if(!Department::create([
            'name' => $request->name,
            'description' => $request->description
        ]))
            return back()->with('message', 'Error in adding department. Please try again');

        return back()->with('message', 'Department added.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentStoreRequest $request)
    {
        $department = Department::find($request->id);

        if(!$department->update([
            'name' => $request->name,
            'description' => $request->description
        ]))
            return back()->with('message', 'Error in updating department. Please try again.');

        return back()->with('message', 'Department updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $department = Department::find($request->id);
        //delete department courses
        foreach($department->courses as $course)
        {
            //delete the subjects of the course
            foreach($course->subjects as $sub)
            {
                if(!$sub->delete())
                    return back()->with('message', 'Error in deleting subjects. Please try again.');
            }
            //delete the enrollments of the course
            foreach($course->enrollments as $enroll)
            {
                if(!$enroll->delete())
                    return back()->with('message', 'Error in deleting enrollments. Please try again.');
            }

            if(!$course->delete())
                return back()->with('message', 'Error in deleting courses. Please try again.'); 
        }
        //delete department faculties
        foreach($department->faculties as $fac)
        {
            //delete faculty classes
            foreach($fac->klases as $klase)
            {
                if(!$klase->delete())
                    return back()->with('message', 'Error in deleting faculty classes. Please try again.');
            }

            if(!$fac->delete())
                return back()->with('message', 'Error in deleting faculty. Please try again.');
        }

        if(!$department->delete())
            return back()->with('message', 'Error in deleting department. Please try again.');

        return back()->with('message', 'Department deleted.');
    }
}
