<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Faculty;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\QCategory;
use App\Models\Department;
use App\Models\Enrollment;
use Illuminate\Support\Arr;
use App\Charts\FacultyChart;
use Illuminate\Http\Request;
use App\Models\EvaluateDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        switch(auth()->user()->type)
        {
            case 1: //Admin Home
                //get all period
                $period = Period::latest('id')
                            -> get();
                
                //overall chart
                $overAllChart = new FacultyChart();

                $overAllChart-> labels(['One', 'Two', 'Three', 'Four']);
                //get improvement by period
                /* foreach($period as $per)
                {
                    $labels = [];
                    $rawAttDept = [];
                    $i = 0;
                    //get departments
                    $department = Department::latest('id')
                                    -> get();
                    //get overall from every department
                    foreach($department as $dept)
                    {
                        $rawAttFac = [];
                        //get every faculty inside the department
                        foreach($dept->faculties as $fac)
                        {
                            //get all evaluations from the faculty on that period
                            $evaluation = Evaluate::where('evaluatee', $fac->user_id)
                                            -> whereDate('created_at', '>=', $per->beginEval)
                                            -> whereDate('created_at', '<=', $per->endEval)
                                            -> latest('id')
                                            -> get();
                            
                            if($evaluation->isEmpty())
                            {
                                $attributes = [random_int(1, 100), random_int(1, 100), random_int(1, 100), random_int(1, 100), random_int(1, 100)];
                                $prevAtt = [random_int(1, 100), random_int(1, 100), random_int(1, 100), random_int(1, 100), random_int(1, 100)];
                            }
                            else
                            {  
                                $catCount = 0;
                                $catPts = 0;
                                //get statistics based on evaluation
                                foreach($evaluation as $eval)
                                {
                                    $prevCat = 0;
        
                                    foreach($eval->evalDetails as $detail)
                                    {
                                        //only gets the quantitative question
                                        if($detail->question->q_type_id == 1)
                                        {        
                                            if($prevCat != $detail->question->qcat->id && $prevCat != 0)
                                            {
                                                $final = ($catPts / ($catCount * 5)) * 100;
                                                $before = $rawAttFac[$prevCat];
        
                                                $rawAttFac[$prevCat] = $rawAttFac[$prevCat] == 0? round($final, 0) : round(($rawAttFac[$prevCat] + $final) / 2, 0);
                                            
                                                $catCount = 0;
                                                $catPts = 0;
                                            }
        
                                            $prevCat = $detail->question->qcat->id;
        
                                            if($prevCat == $detail->question->qcat->id || $prevCat == 0)
                                            {
                                                $catPts += $detail->answer;
                                                $catCount += 1;
                                            }
                                        }
                                    }
                                    if($catPts != 0)
                                    {
                                        $final = ($catPts / ($catCount * 5)) * 100;
                                        $rawAttFac[$prevCat] = $rawAttFac[$prevCat] == 0? round($final, 0) : round(($rawAttFac[$prevCat] + $final) / 2, 0);
        
                                        $catCount = 0;
                                        $catPts = 0;
                                    }
                                }                                                            
                                $attributes = array();
                                $attributes = array_merge($attributes, $rawAttFac);
                            }
                            $average[$dept->id] = collect($attributes)->avg();
                            $prevAvg[$dept->id] = collect($prevAtt)->avg();
                        }
                    }
                    //chart details
                    $overAllChart-> dataset($per->getDescription(), 'radar', $attributes);
                } */
                $overAllChart-> dataset('Chart Name 1', 'line', [10, 40, 50]);
                $overAllChart-> dataset('Chart Name 2', 'line', [20, 25, 80]);

                //evaluation progress chart only show latest period
                $p = $period->first();
                //faculty
                $evalProgressF = new FacultyChart(); 

                if(isset($p->beginEval))
                {
                    $evaluation = Evaluate::whereExists(function ($query) {
                                            $query->select(DB::raw(1))
                                                -> from('faculties')
                                                -> whereColumn('faculties.user_id', 'evaluates.evaluator');
                                        })
                                        -> whereDate('created_at', '>=', $p->beginEval)
                                        -> whereDate('created_at', '<=', $p->endEval)
                                        -> get();
                    
                    //get finished evaluations
                    $finishedf = $evaluation->count();
                    //get expected evaluations
                    //get each department
                    $dept = Department::latest('id')
                                    -> get();

                    $expectedf = 0;
                    //count total number of expected evaluations by multiplying number of faculty to itself minus 1 excluding the evaluator
                    foreach($dept as $det)
                        $expectedf += $det->faculties->count() > 0? ($det->faculties->count()/*  * $det->faculties->count() - 1 */) : 0;

                    $pendingf = $expectedf - $finishedf;
                                        
                    //chart details
                    $evalProgressF-> labels(['Pending', 'Finished'])
                        -> dataset('Chart Name', 'doughnut', [30, 70])
                        -> backgroundColor(['Yellow', 'Green'])/* 
                        -> options([
                            'maintainAspectRatio' => true,
                            'responsive' => true,
                            'tooltips' => [ 
                                'callbacks' => [
                                    'label' => ['10%', '50%']
                                ]
                            ]
                        ]) */;

                    //student
                    $evalProgressS = new FacultyChart();
                    //get enrollment query
                    $enrollment = Enrollment::where('period_id', $p->id)
                                        -> latest('id')
                                        -> get();

                    //number of finished evaluations
                    $finisheds = 0;
                    
                    foreach($enrollment as $det)
                        $finisheds += $det->user->evaluates->count();

                    //number of evaluations when completed
                    $expecteds = 0;

                    foreach($enrollment as $det)
                        $expecteds += $det->user->klaseStudent->klase->block->klases->count();
                    
                    //pending
                    $pendings = $expecteds - $finisheds;
                    
                    //chart details
                    $evalProgressS-> labels(['Pending', 'Finished'])
                        -> dataset('Chart Name', 'doughnut', [$pendings, $finisheds])
                        -> backgroundColor(['Yellow', 'Green'])/* 
                        -> options([
                            'maintainAspectRatio' => true,
                            'responsive' => true,
                            'tooltips' => [ 
                                'callbacks' => [
                                    'label' => ['10%', '50%']
                                ]
                            ]
                        ]) */;

                    /* $evalProgress-> labels(['Pending', 'Finished'])
                        -> dataset('Progess', 'doughnut', [75, 25])
                        -> backgroundColor(['Yellow', 'Green'])
                        -> options(['responsive' => true]); */
                }
                else
                {
                    $evalProgressF = null;
                    $evalProgressS = null;
                }
                
                
                return view('admin.index', compact('overAllChart', 'evalProgressF', 'evalProgressS'));
                break;
            case 2: //SAST Officer Home
                //percentage done chartFaculty
                $chartFaculty = new FacultyChart();
                //get period
                $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));
                //get evaluations from starting evaluation period to end
                if(isset($period->beginEval))
                {
                    $evaluation = Evaluate::whereExists(function ($query) {
                                        $query->select(DB::raw(1))
                                            -> from('faculties')
                                            -> whereColumn('faculties.user_id', 'evaluates.evaluator');
                                    })
                                    -> whereDate('created_at', '>=', $period->beginEval)
                                    -> whereDate('created_at', '<=', $period->endEval)
                                    -> get();
                    //get finished evaluations
                    $finishedf = $evaluation->count();
                    //get expected evaluations
                    //get each department
                    $dept = Department::latest('id')
                                    -> get();
                    
                    $expectedf = 0;
                    //count total number of expected evaluations by multiplying number of faculty to itself minus 1 excluding the evaluator
                    foreach($dept as $det)
                        $expectedf += $det->faculties->count() > 0? ($det->faculties->count()/*  * $det->faculties->count() - 1 */) : 0;

                    $pendingf = $expectedf - $finishedf;
                                        
                    //chart details
                    $chartFaculty-> labels(['Pending', 'Finished'])
                        -> dataset('Chart Name', 'doughnut', [$pendingf, $finishedf])
                        -> backgroundColor(['Yellow', 'Green'])/* 
                        -> options([
                            'maintainAspectRatio' => true,
                            'responsive' => true,
                            'tooltips' => [ 
                                'callbacks' => [
                                    'label' => ['10%', '50%']
                                ]
                            ]
                        ]) */;
                    //percentage done chartStudent
                    $chartStudent = new FacultyChart();
                    //get enrollment query
                    $enrollment = Enrollment::where('period_id', $period->id)
                                        -> latest('id')
                                        -> get();
                    //total enrollee
                    $totalEnrollees  = $enrollment->count();
                    //number of finished evaluations
                    $finisheds = 0;
                    
                    foreach($enrollment as $det)
                        $finisheds += $det->user->evaluates->count();

                    //number of evaluations when completed
                    $expecteds = 0;

                    foreach($enrollment as $det)
                        $expecteds += $det->user->klaseStudent->klase->block->klases->count();
                    
                    //pending
                    $pendings = $expecteds - $finisheds;
                    
                    //chart details
                    $chartStudent-> labels(['Pending', 'Finished'])
                        -> dataset('Chart Name', 'doughnut', [$pendings, $finisheds])
                        -> backgroundColor(['Yellow', 'Green'])/* 
                        -> options([
                            'maintainAspectRatio' => true,
                            'responsive' => true,
                            'tooltips' => [ 
                                'callbacks' => [
                                    'label' => ['10%', '50%']
                                ]
                            ]
                        ]) */;
                }
                else
                    return view('sast.index', compact('period'));

                return view('sast.index', compact('period', 'chartFaculty', 'finishedf', 'pendingf', 'expectedf', 'chartStudent', 'totalEnrollees', 'finisheds', 'pendings', 'expecteds'));
                break;
            case 3: 
                //get current period
                $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));                
                //attributes chart 
                $chart = new FacultyChart();

                $labels = [];
                $rawAtt = [];
                $lowestAttribute = 0;
                $i = 0;
                //get all categories
                $category = QCategory::all();
                //get all categories
                foreach($category as $det)
                {
                    $labels[$i++] = $det->name;
                    $rawAtt[$det->id] = 0;
                }
                $baseAttribute = 0;
                //get evaluations of user
                $evaluation = Evaluate::where('evaluatee', auth()->user()->id)
                                    -> latest('id')
                                    -> get();
                //randomize if mempty
                if($evaluation->isEmpty())
                    $attributes = [random_int(1, 100), random_int(1, 100), random_int(1, 100), random_int(1, 100), random_int(1, 100)];
                else
                {
                    $catCount = 0;
                    $catPts = 0;
                    //get statistics based on evaluation
                    foreach($evaluation as $det)
                    {
                        $prevCat = 0;
                        foreach($det->evalDetails as $detail)
                        {
                            //only gets the quantitative question
                            if($detail->question->q_type_id == 1)
                            {
                               /*  dump($prevCat . ' ' . $detail->question->qcat->id . ' ' . $catCount); */
                                
                                if($prevCat != $detail->question->qcat->id && $prevCat != 0)
                                {
                                    $final = ($catPts / ($catCount * 5)) * 100;
                                    $before = $rawAtt[$prevCat];

                                    $rawAtt[$prevCat] = $rawAtt[$prevCat] == 0? round($final, 0) : round(($rawAtt[$prevCat] + $final) / 2, 0);
                                
                                    if($lowestAttribute == 0)
                                        $lowestAttribute = $prevCat;
                                    
                                    if($rawAtt[$prevCat] < $rawAtt[$lowestAttribute])
                                        $lowestAttribute = $detail->question->qcat->id;
                                        /* dump( //BUANG PA ANG CHART SA DEAN
                                            'Previous Category: ' . $prevCat .
                                            ' Current Category: ' . $detail->question->qcat->id .
                                            ' Current Answer: ' . $detail->answer .
                                            ' Total: ' . $catPts .
                                            ' Overall: ' . ($catCount * 5) .
                                            ' Final:  ' . $final .
                                            ' Before: ' . $before .
                                            ' Current Attribute (' . $detail->question->qcat->name . '): ' . $rawAtt[$prevCat]
                                        ); */
                                    $catCount = 0;
                                    $catPts = 0;
                                }

                                $prevCat = $detail->question->qcat->id;

                                if($prevCat == $detail->question->qcat->id || $prevCat == 0)
                                {
                                    $catPts += $detail->answer;
                                    $catCount += 1;
                                }/* dump($catPts); */
                            }
                            
                            /* 
                            if($detail->question->q_type_id == 1)
                            {
                                dump($prevCat . ' ' . $detail->question->qcat->id);
                                if($prevCat != $detail->question->qcat->id && $catPts != 0)
                                {
                                    if($prevCat == 0)
                                        $prevCat = $detail->question->qcat->id;
                                        
                                    $final = ($catPts / ($catCount * 5)) * 100;
                                    $before = $rawAtt[$detail->question->qcat->id];

                                    $rawAtt[$detail->question->qcat->id] = $rawAtt[$detail->question->qcat->id] == 0? round($final, 0) : round(($rawAtt[$detail->question->qcat->id] + $final )/ 2, 0);
                                    
                                    if($lowestAttribute == 0)
                                        $lowestAttribute = $detail->question->qcat->id;
                                    
                                    if($rawAtt[$detail->question->qcat->id] < $rawAtt[$lowestAttribute])
                                        $lowestAttribute = $detail->question->qcat->id;
                                        dump( //BUANG PA ANG CHART SA DEAN
                                            'Previous Category: ' . $prevCat .
                                            ' Current Category: ' . $detail->question->qcat->id .
                                            ' Current Answer: ' . $detail->answer .
                                            ' Total: ' . $catPts .
                                            ' Overall: ' . ($catCount * 5) .
                                            ' Final:  ' . $final .
                                            ' Before: ' . $before .
                                            ' Current Attribute (' . $detail->question->qcat->name . '): ' . $rawAtt[$detail->question->qcat->id]
                                        );
                                    $catPts = 0;
                                    $catCount = 0;
                                }

                                $prevCat = $detail->question->qcat->id;
                                if($prevCat == $detail->question->qcat->id)
                                {
                                    $catPts += $detail->answer;
                                    $catCount += 1;
                                }

                                if($prevCat == count($labels))
                                {
                                    $final = ($catPts / ($catCount * 5)) * 100;

                                    $rawAtt[$prevCat] = $rawAtt[$prevCat] == 0? round($final, 0) : round(($rawAtt[$prevCat] + $final )/ 2, 0);

                                    if($lowestAttribute == 0)
                                        $lowestAttribute = $detail->question->qcat->id;
                                        
                                    if($rawAtt[$prevCat] < $rawAtt[$lowestAttribute])
                                        $lowestAttribute = $detail->question->qcat->id;
                                }
                            } */
                        }
                        if($catPts != 0)
                        {
                            $final = ($catPts / ($catCount * 5)) * 100;
                            $rawAtt[$prevCat] = $rawAtt[$prevCat] == 0? round($final, 0) : round(($rawAtt[$prevCat] + $final) / 2, 0);
                                
                            if($lowestAttribute == 0)
                                $lowestAttribute = $prevCat;
                            
                            if($rawAtt[$prevCat] < $rawAtt[$lowestAttribute])
                                $lowestAttribute = $detail->question->qcat->id;

                            $catCount = 0;
                            $catPts = 0;
                        }
                    }

                    $recommendation = Question::where('q_category_id', $lowestAttribute)
                                                -> where('q_type_id', 1)
                                                -> latest('id')
                                                -> get();
                }
                $attributes = array();
                $attributes = array_merge($attributes, $rawAtt);
                //chart details
                $chart-> labels($labels)
                    -> dataset($period->getDescription(), 'radar', $attributes)
                    -> options([
                        'min' => 0,
                        'max' => 100,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'pointBorderColor' => 'Blue',
                        'scales' => [
                            'min' => 0,
                            'max' => 100,
                            'ticks' => [
                                'stepSize' => 20,
                                'display' => false
                        ]],
                        'responsive' => true
                    ]);
                //get faculties in same department
                $faculty = Faculty::where('department_id', auth()->user()->faculties[0]->department_id)
                            -> where('user_id', '!=', auth()->user()->id)
                            -> latest('id')
                            -> get();
                
                return view('faculty.index', compact('period', 'faculty', 'chart'));
                break;
            case 4:
                $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));

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
