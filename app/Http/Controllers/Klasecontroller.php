<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\BlockStudent;
use App\Models\Klase;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\KlaseStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Klasecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Block $block)
    {
        $klase = Klase::with('faculties')
                    -> with('klaseStudents')
                    -> where('block_id', $block->id)
                    -> latest('id')
                    -> get();

        $students = BlockStudent::with('user')
                            -> where('block_id', $block->id)
                            -> latest('id')
                            -> get();

        return view('klase.index', compact('block', 'klase', 'students'));
    }

    public function crossDept(Request $request)
    {
        $request->session()->put('crossDept', (boolean) $request->crossDept);

        return back()->with('message', $request->crossDept? 'Cross department assignment allowed.' : 'Cross department assignment not allowed.');
    }

    public function assignInstructor(Request $request)
    {
        $allowCrossDept = Session::get('crossDept') != null? Session::get('crossDept') : false;
        $klase = decrypt($request->klase);
        $klase = Klase::find($klase);
        $department = decrypt($request->department);

        $faculty = Faculty::where(function ($query) use ($department, $allowCrossDept)
                            {
                                if(!$allowCrossDept)
                                    $query->where('department_id', $department);
                            })
                            -> latest('id')
                            -> get();

        return view('klase.assignClass', compact('klase', 'faculty', 'allowCrossDept'));
    }

    public function assignInstructorProcess(Request $request, Klase $klase)
    {
        if(!$klase->update([
            'instructor' => $request->instructor,
            'schedule' => $request->schedule
        ]))
            return back()->with('message', 'Error in assigning instructor. Please try again.');

        $request->session()->put('crossDept', null);

        return redirect(route('klase.manage', $klase->block_id))->with('message', 'Instructor assigned.');
    }

    public function classStudent(Klase $klase)
    {
        $students = $klase->klaseStudents;
        
        return view('klase.students', compact('klase', 'students'));
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
