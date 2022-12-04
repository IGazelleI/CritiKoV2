<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Faculty;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\QCategory;
use App\Models\Enrollment;
use App\Charts\FacultyChart;
use App\Models\EvaluateDetail;
use Illuminate\Http\Request;
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
            case 3: $chart = new FacultyChart();

                    $labels = [];
                    $attributes = [];
                    $i = 0;

                    $category = QCategory::latest('id')
                                -> get();

                    foreach($category as $det)
                    {
                        $labels[$i] = $det->name;
                        $cat[$i] = $det->id;

                        $i += 1;
                    }

                    $evaluation = Evaluate::where('evaluatee', auth()->user()->id)
                                        -> latest('id')
                                        -> get();

                    if($evaluation->isEmpty())
                        $points = [random_int(1, 100), random_int(1, 100), random_int(1, 100), random_int(1, 100), random_int(1, 100)];
                    else
                    {
                        foreach($evaluation as $det)
                        {     /* IADD ang points sa category base sa evaldetail */
                            foreach($det->evalDetails as $detail)
                                $points[$i] = $detail;

                            $i += 1;
                        }
                    }
                    
                    $chart-> labels($labels)
                        -> dataset('Latest', 'radar', $points)
                        -> options([
                        'pointBorderColor' => 'Blue',
                        'scales' => [
                                        'r' => [
                                        'min' => 50,
                                        'max' => 100,
                                        'ticks' => [
                                                'stepSize' => 20,
                                                'display' => false
                                        ]
                                ]
                        ],
                        'responsive' => true
                    ]);

                    $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));

                    $faculty = Faculty::where('department_id', auth()->user()->faculties[0]->department_id)
                                -> where('user_id', '!=', auth()->user()->id)
                                -> latest('id')
                                -> get();
                
                    return view('faculty.index', compact('period', 'faculty', 'chart'));
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
