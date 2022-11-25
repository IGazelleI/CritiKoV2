<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Http\Requests\SubjectStoreRequest;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course)
    {
        $subject = Subject::all();

        return view('subject.index', compact('subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectStoreRequest $request)
    {
        if(!Subject::create([
            'course_id' => $request->course_id,
            'code' => $request->code,
            'descriptive_title' => $request->descriptive_title,
            'semester' => $request->semester
        ]))
            return back()->with('message', 'Error in adding subject. Please try again');

        return back()->with('message', 'Subject added.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectStoreRequest $request)
    {
        $subject = Subject::find($request->id);

        if(!$subject->update([
            'course_id' => $request->course_id,
            'code' => $request->code,
            'descriptive_title' => $request->descriptive_title,
            'semester' => $request->semester
        ]))
            return back()->with('message', 'Error in updating subject. Please try again.');

        return back()->with('message', 'Subject updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $subject = Subject::find($request->id);

        if(!$subject->delete())
            return back()->with('message', 'Error in deleting subject. Please try again.');

        return back()->with('message', 'Subject deleted.');
    }
}
