<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Period;
use App\Models\Enrollment;
use App\Models\Question;
use App\Models\Faculty;
use App\Models\Evaluate;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        switch(auth()->user()->type)
        {
            case 1: return view('admin.index');
                    break;
            case 2: return view('sast.index');
                    break;
            case 3: return view('faculty.index');
                    break;
            case 4: $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));

                    $enrollment = Enrollment::where('user_id', auth()->user()->id)
                                        -> where('period_id', $period->id)
                                        -> latest('id')
                                        -> get()
                                        -> first();
                    
                    $question = Question::where('type', 4)
                                    -> orderBy('q_type_id')
                                    -> orderBy('q_category_id')
                                    -> get();
            
                    $instructor = isset($enrollment)? Faculty::join('klases', 'faculties.user_id', 'klases.instructor')
                                                        -> join('blocks', 'klases.block_id', 'blocks.id')
                                                        -> where('faculties.department_id', auth()->user()->students[0]->enrollments[0]->course->department_id)
                                                        -> latest('faculties.user_id')
                                                        -> get() : null;
            
                    $currentSelected = Session::get('selected');
            
                    $evaluation = $currentSelected != null? Evaluate::where('evaluator', auth()->user()->id)
                                                                    -> where('evaluatee', $currentSelected)
                                                                    -> where('period_id', Session::get('period'))
                                                                    -> latest('id')
                                                                    -> get()
                                                                    -> first() : null;

                    return view('student.index', compact('instructor'));
                    break;
        }
    }
}
