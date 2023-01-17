<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\QCategory;
use App\Models\Department;
use App\Models\Enrollment;
use App\Charts\FacultyChart;
use App\Models\AcademicYear;
use App\Models\KlaseStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        switch(auth()->user()->type)
        {
            case 1: //Admin Home
                //sort by
                $sortByAcad = $request->sortByAcad;
                //get all period
                $period = Period::orderBy('id')
                            -> get();
                
                //overall chart
                $overAllChart = new FacultyChart();
                $periodArr = [];
                //get categories
                $cat = QCategory::latest('id')
                            -> get();
                //get improvement by period
                if($sortByAcad)
                {
                    $acadYears = AcademicYear::with('periods')
                                            -> latest('id')
                                            -> get();

                    if(!$acadYears->isEmpty())
                    {
                        if(!$period->isEmpty())
                        {
                            $department = Department::with('faculties')
                                                -> latest('id')
                                                -> get();
                            //get average by department
                            if(!$department->isEmpty())
                            {
                                //color variable
                                $i = 0;

                                foreach($department as $dept)
                                {
                                    $avgRaw = [];
                                    //get average of department by acadmic year
                                    foreach($acadYears->sortBy('begin') as $acad)
                                    {
                                        $period = $acad->periods;

                                        foreach($period as $per)
                                        {
                                            //checks if currnet department's faculty is empty
                                            if(!$dept->faculties->isEmpty())
                                            {
                                                $facAvg = 0; 
                                                $stAvg = 0;
                                                ///loop through all faculties
                                                foreach($dept->faculties as $fac)
                                                {
                                                    //get details for current faculty
                                                    //faculty evaluations
                                                    $facEvalDetails = $this->getDetails($per, 3, $fac);
                                                    //get average of faculties evaluation
                                                    if($facEvalDetails !=  null)
                                                        $facAvg = $facAvg == 0? collect($facEvalDetails->attributes)->avg() : ($facAvg + collect($facEvalDetails->attributes)->avg()) / 2;
                                                    else
                                                        $facAvg = $facAvg == 0? collect($this->randomAttributes($cat->where('type', 3)->count()))->avg() : ($facAvg + collect($this->randomAttributes($cat->where('type', 3)->count()))->avg())/*  / 2 */;
                                                    //student evaluations
                                                    $stEvalDetails = $this->getDetails($per, 4, $fac);
                                                    //get average of students evaluation
                                                    if($stEvalDetails != null)
                                                        $stAvg = $stAvg == 0? collect($stEvalDetails->attributes)->avg() : ($stAvg + collect($stEvalDetails->attributes)->avg()) / 2;
                                                    else
                                                        $stAvg = $stAvg == 0? collect($this->randomAttributes($cat->where('type', 4)->count()))->avg() : ($stAvg + collect($this->randomAttributes($cat->where('type', 4)->count()))->avg())/*  / 2 */;
                                                }
                                                //get the average of the two but only put one if there is no evaluations on other
                                                $avgRaw[$acad->id] = ($facAvg > 0 && $stAvg == 0 || $facAvg == 0 && $stAvg > 0)? ($facAvg == 0? round($stAvg, 2) : round($facAvg, 2))  : round(($facAvg + $stAvg) / 2, 2);
                                            }
                                            else //randomize if empty lang sa
                                                $avgRaw[$acad->id] = random_int(0, 0);
                                        }
                                        //merge array so it will start to 1
                                        $average = array();
                                        $average = array_merge($average, $avgRaw); 
                                        //getting chart label purposes
                                        if($i == 0)
                                            $periodArr = array_merge($periodArr, [$acad->getDescription()]);
                                    }
                                    //chart details
                                    $overAllChart->dataset($dept->name, 'line', $average)
                                            -> options([
                                                'backgroundColor' => $this->colors($i)->bg,
                                                'pointBorderColor' => $this->colors($i)->pointer,
                                                'borderColor' => $this->colors($i)->bg,
                                                'scales' => [
                                                    'r' => [
                                                        'min' => 0,
                                                        'max' => 100
                                                    ]
                                                ]
                                            ]);

                                    $i += 1;
                                }
                            }
                            //initialize the chart labels
                            $overAllChart-> labels($periodArr);
                        }
                    }
                }
                else
                {
                    if(!$period->isEmpty())
                    {
                        $department = Department::with('faculties')
                                            -> latest('id')
                                            -> get();
                        //get average by department
                        if(!$department->isEmpty())
                        {
                            //color variable
                            $i = 0;

                            foreach($department as $dept)
                            {
                                $avgRaw = [];
                                //get average of department by period
                                foreach($period as $per)
                                {
                                    $avgPeriod[$per->id] = 0;
                                    //checks if currnet department's faculty is empty
                                    if(!$dept->faculties->isEmpty())
                                    {
                                        $facAvg = 0; 
                                        $stAvg = 0;
                                        ///loop through all faculties
                                        foreach($dept->faculties as $fac)
                                        {
                                            //get details for current faculty
                                            //faculty evaluations
                                            $facEvalDetails = $this->getDetails($per, 3, $fac);
                                            //get average of faculties evaluation
                                            if($facEvalDetails !=  null)
                                                $facAvg = $facAvg == 0? collect($facEvalDetails->attributes)->avg() : ($facAvg + collect($facEvalDetails->attributes)->avg()) / 2;
                                            else
                                                $facAvg = $facAvg == 0? collect($this->randomAttributes($cat->where('type', 3)->count()))->avg() : ($facAvg + collect($this->randomAttributes($cat->where('type', 3)->count()))->avg())/*  / 2 */;
                                            //student evaluations
                                            $stEvalDetails = $this->getDetails($per, 4, $fac);
                                            //get average of students evaluation
                                            if($stEvalDetails != null)
                                                $stAvg = $stAvg == 0? collect($stEvalDetails->attributes)->avg() : ($stAvg + collect($stEvalDetails->attributes)->avg()) / 2;
                                            else
                                                $stAvg = $stAvg == 0? collect($this->randomAttributes($cat->where('type', 4)->count()))->avg() : ($stAvg + collect($this->randomAttributes($cat->where('type', 4)->count()))->avg())/*  / 2 */;
                                        }
                                        //get the average of the two but only put one if there is no evaluations on other
                                        $avgRaw[$per->id] = ($facAvg > 0 && $stAvg == 0 || $facAvg == 0 && $stAvg > 0)? ($facAvg == 0? number_format($stAvg, 0) : number_format($facAvg, 0))  : number_format(($facAvg + $stAvg) / 2, 0);
                                    }
                                    else //randomize if empty lang sa
                                        $avgRaw[$per->id] = random_int(0, 0);
                                    //merge array so it will start to 1
                                    $average = array();
                                    $average = array_merge($average, $avgRaw); 
                                    //getting chart label purposes
                                    if($i == 0)
                                        $periodArr = array_merge($periodArr, [$per->getDescription()]);
                                }
                                //chart details
                                $overAllChart->dataset($dept->name, 'line', $average)
                                        -> options([
                                            'backgroundColor' => $this->colors($i)->bg,
                                            'pointBorderColor' => $this->colors($i)->pointer,
                                            'borderColor' => $this->colors($i)->bg,
                                            'scales' => [
                                                'r' => [
                                                    'min' => 0,
                                                    'max' => 100
                                                ]
                                            ]
                                        ]);

                                $i += 1;
                            }
                        }
                        //initialize the chart labels
                        $overAllChart-> labels($periodArr);
                    }
                }

                //evaluation progress chart only show latest period
                $p = $period->last();
                //faculty
                $evalProgress = new FacultyChart(); 

                if(isset($p->beginEval))
                {
                    $evaluation = Evaluate::whereExists(function ($query) {
                                            $query->select(DB::raw(1))
                                                -> from('faculties')
                                                -> whereColumn('faculties.user_id', 'evaluates.evaluator');
                                        })
                                        -> where('period_id', $p->id)/* 
                                        -> whereDate('created_at', '>=', $p->beginEval)
                                        -> whereDate('created_at', '<=', $p->endEval) */
                                        -> get();
                    //student
                    //get enrollment query
                    $enrollment = Enrollment::with('user')
                                        -> where('period_id', $p->id)
                                        -> where('status', 'Approved')
                                        -> latest('id')
                                        -> get();
                    //total enrollee
                    $totalEnrollees  = $enrollment->count();
                    //number of finished evaluations
                    $finisheds = 0;
                    
                    foreach($enrollment as $det)
                    {
                        $finisheds += 1;
                        foreach($det->user->klaseStudents as $detail)
                        {
                            if($det->user->evaluates->where('evaluatee', $detail->klase->instructor)->first() == null)
                            {
                                $finisheds -= 1;
                                break;
                            }
                        }
                    }
                    
                    //pending
                    $pendings = $totalEnrollees - $finisheds;
                    
                    //chart details
                    $evalProgress-> dataset('Student', 'bar', [$pendings, $finisheds])
                        -> backgroundColor(['rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)'])/* 
                        -> options([
                            'maintainAspectRatio' => true,
                            'responsive' => true,
                            'tooltips' => [ 
                                'callbacks' => [
                                    'label' => ['10%', '50%']
                                ]
                            ]
                        ]) */;
                    //get finished evaluations
                    $finishedf = 0;
                    //get expected evaluations
                    //get each department
                    $dept = Department::with('faculties')
                                    -> latest('id')
                                    -> get();
                    
                    $expectedf = 0;
                    //count total number of expected evaluations by multiplying number of faculty to itself minus 1 excluding the evaluator
                    foreach($dept as $det)
                    {
                        if(!$det->faculties->isEmpty())
                        {
                            $expectedf += $det->faculties->count();

                            foreach($det->faculties as $fac)
                            {
                                $finishedf += 1;

                                foreach($det->faculties->where('id', '!=', $fac->id) as $facEval)
                                {
                                    //get the classes of faculty
                                    $block = Block::with('klases')->where('period_id', $p->id)->get();

                                    if(!$block->isEmpty())
                                    {
                                        foreach($block as $b)
                                        {
                                            foreach($b->klases->where('instructor', $facEval->user_id) as $klase)
                                            {
                                                if($evaluation->where('evaluator', $fac->user_id)->where('evaluatee', $facEval->user_id)->where('subject_id', $klase->subject_id)->isEmpty())
                                                {
                                                    $finishedf -= 1;
                                                    break 3;
                                                }      
                                            }
                                        }
                                    }            
                                }
                            }
                        }
                    }

                    $pendingf = $expectedf - $finishedf;
                                        
                    //chart details
                    $evalProgress-> labels(['Pending', 'Finished'])
                        -> dataset('Faculty', 'bar', [$pendingf, $finishedf])
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
                    $evalProgress = null;                
                
                return view('admin.index', compact('sortByAcad', 'overAllChart', 'evalProgress', 'p', 'department'));
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
                                    -> where('period_id', $period->id)/* 
                                    -> whereDate('created_at', '>=', $period->beginEval)
                                    -> whereDate('created_at', '<=', $period->endEval) */
                                    -> get();
                    //get finished evaluations
                    $finishedf = 0;
                    //get expected evaluations
                    //get each department
                    $dept = Department::with('faculties')
                                    -> latest('id')
                                    -> get();
                    
                    $expectedf = 0;
                    //count total number of expected evaluations by multiplying number of faculty to itself minus 1 excluding the evaluator
                    foreach($dept as $det)
                    {
                        if(!$det->faculties->isEmpty())
                        {
                            $expectedf += $det->faculties->count();

                            foreach($det->faculties as $fac)
                            {
                                $finishedf += 1;

                                foreach($det->faculties->where('id', '!=', $fac->id) as $facEval)
                                {
                                    //get the classes of faculty
                                    $block = Block::with('klases')->where('period_id', $period->id)->get();

                                    if(!$block->isEmpty())
                                    {
                                        foreach($block as $b)
                                        {
                                            foreach($b->klases->where('instructor', $facEval->user_id) as $klase)
                                            {
                                                if($evaluation->where('evaluator', $fac->user_id)->where('evaluatee', $facEval->user_id)->where('subject_id', $klase->subject_id)->isEmpty())
                                                {
                                                    $finishedf -= 1;
                                                    break 3;
                                                }      
                                            }
                                        }
                                    }            
                                }
                            }
                        }
                    }

                    $pendingf = $expectedf - $finishedf;
                                        
                    //chart details
                    $chartFaculty-> labels(['Pending', 'Finished'])
                        -> dataset('Faculty', 'doughnut', [$pendingf, $finishedf])
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
                    $enrollment = Enrollment::with('user')
                                        -> where('period_id', $period->id)
                                        -> where('status', 'Approved')
                                        -> latest('id')
                                        -> get();
                    //total enrollee
                    $totalEnrollees  = $enrollment->count();
                    //number of finished evaluations
                    $finisheds = 0;
                    
                    foreach($enrollment as $det)
                    {
                        $finisheds += 1;
                        foreach($det->user->klaseStudents as $detail)
                        {
                            if($det->user->evaluates->where('evaluatee', $detail->klase->instructor)->first() == null)
                            {
                                $finisheds -= 1;
                                break;
                            }
                        }
                    }
                    
                    //pending
                    $pendings = $totalEnrollees - $finisheds;
                    
                    //chart details
                    $chartStudent-> labels(['Pending', 'Finished'])
                        -> dataset('Student', 'doughnut', [$pendings, $finisheds])
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
                    
                    $variables = ['period', 'chartFaculty', 'finishedf', 'pendingf', 'expectedf', 'chartStudent', 'totalEnrollees', 'finisheds', 'pendings'];
                }
                else
                    return view('sast.index', compact('period'));

                return view('sast.index', compact($variables));
                break;
            case 3: //Faculty Home 
                //previous limit
                $prevLimit = Session::get('prevLimit') == null? 1 : Session::get('prevLimit');
                //get current period
                $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));                
                //student attributes chart 
                $studentChart = new FacultyChart();
                $studentChart->options([
                    'min' => 0,
                    'max' => 100,
                    'backgroundColor' => $this->colors(0)->bg, 
                    'pointBorderColor' => $this->colors(0)->pointer,
                    'scales' => [
                        'r' => [
                            'min' => 0,
                            'max' => 5,
                            'ticks' => [
                                'stepSize' => 20,
                                'display' => false
                            ]
                    ]],
                    'responsive' => true
                ]);

                $details = $this->getDetails($period, 4, null);
                
                $recommendation['studentEvaluation'] = isset($details)? Question::select('keyword')
                                        -> where('q_category_id', $details->lowestAttribute)
                                        -> where('q_type_id', 1)
                                        -> latest('id')
                                        -> get() : null;
                //chart details
                $cat = $this->getCategoriesAsArray(4);
                $studentChart->labels($cat)
                    -> dataset($period->getDescription(), 'bar', $details == null? $this->randomAttributes(count($cat)) : $details->attributes);

                //Select all previous evaluations
                $periods = Period::where('id', '<', $period->id)
                                -> latest('id')
                                -> get();

                if(!$periods->isEmpty())
                {
                    $i = 1;
                    foreach($periods as $det)
                    {
                        if($i <= $prevLimit)
                        {
                            $prevDetails = $this->getDetails($det, 4, null);

                            if($prevDetails == null)
                                $studentChart->dataset($det->getDescription(), 'bar', $this->randomAttributes(count($cat)))->options(['backgroundColor' => $this->colors($i)->bg, 'pointBorderColor' => $this->colors($i)->pointer]);
                            else
                                $studentChart->dataset($det->getDescription(), 'bar', $prevDetails->attributes)->options(['backgroundColor' => $this->colors($i)->bg, 'pointBorderColor' => $this->colors($i)->pointer]);
                        }
                        else
                            break;

                        $i += 1;
                    }
                }
                $sumSt = $this->getSummary($period, 4);

                //faculties attributes chart
                $facultyChart = new FacultyChart();
                $facultyChart->options([
                    'min' => 0,
                    'max' => 100,
                    'backgroundColor' => $this->colors(0)->bg,
                    'pointBorderColor' => $this->colors(0)->pointer,
                    'scales' => [
                        'r' => [
                            'min' => 0,
                            'max' => 5,
                            'ticks' => [
                                'stepSize' => 20,
                                'display' => false
                            ]
                    ]],
                    'responsive' => true
                ]);

                $details = $this->getDetails($period, 3, null);

                $recommendation['facultyEvaluation'] = isset($details)? Question::select('isLec', 'keyword')
                                        -> where('q_category_id', $details->lowestAttribute)
                                        -> where('q_type_id', 1)
                                        -> latest('id')
                                        -> get() : null;
                //chart details
                $cat = $this->getCategoriesAsArray(3);
                $facultyChart->labels($cat)
                    -> dataset($period->getDescription(), 'bar', $details == null? $this->randomAttributes(count($cat)) : $details->attributes);

                //Select all previous evaluations
                $periods = Period::where('id', '<', $period->id)
                                -> latest('id')
                                -> get();

                if(!$periods->isEmpty())
                {
                    $i = 1;
                    foreach($periods as $det)
                    {
                        if($i <= $prevLimit)
                        {
                                $prevDetails = $this->getDetails($det, 3, null);

                                if($prevDetails == null)
                                    $facultyChart->dataset($det->getDescription(), 'bar', $this->randomAttributes(count($cat)))->options(['backgroundColor' => $this->colors($i)->bg, 'pointBorderColor' => $this->colors($i)->pointer]);
                                else
                                    $facultyChart->dataset($det->getDescription(), 'bar', $prevDetails->attributes)->options(['backgroundColor' => $this->colors($i)->bg, 'pointBorderColor' => $this->colors($i)->pointer]);
                        }
                        else
                            continue;

                        $i += 1;
                    }
                }
                //get faculties in same department
                if(auth()->user()->faculties->first()->isDean)
                {
                    $faculty = Faculty::where('department_id', auth()->user()->faculties->first()->department_id)
                                    -> where('user_id', '!=', auth()->user()->id)
                                    -> orderBy('isAssDean', 'desc')
                                    -> get();
                }
                else
                { 
                    $faculty = Faculty::where('department_id', auth()->user()->faculties->first()->department_id)
                                    -> where('user_id', '!=', auth()->user()->id)
                                    -> where('isDean', false)
                                    -> where('isAssDean', false)
                                    -> get();
                }

                $sumFac = $this->getSummary($period, 3);
                
                return view('faculty.index', compact('period', 'faculty', 'studentChart', 'facultyChart', 'recommendation', 'sumFac', 'sumSt'));
                break;
            case 4: //Student Home
                //get period selected
                $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));
                //get enrollment status
                $enrollment = Enrollment::where('user_id', auth()->user()->id)
                                    -> where('period_id', $period->id)
                                    -> get()
                                    -> first();
                
                //get the subjects taken
                $blocks =  Block::with('klases')
                            -> where('period_id', $period->id)   
                            -> latest('id')
                            -> get();
                $klases = [];
                foreach($blocks as $det)
                {
                    foreach($det->klases as $klase)
                    {
                        if($klase->klaseStudents->where('user_id', auth()->user()->id)->first())
                            $klases = array_merge($klases, [$klase->id]);
                    }
                }

                $subjects = isset($enrollment)? KlaseStudent::with('klase')
                                    -> where('user_id', auth()->user()->id)
                                    -> whereIn('klase_id', $klases)      
                                    -> latest('id')
                                    -> get() : null;

                return view('student.index', compact('period', 'subjects', 'enrollment'));
                break;
        }
    }
    function colors($i)
    {
        $bg = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(153, 102, 255, 0.2)'];
        $pointer = ['Red', 'Blue', 'Orange', 'Yellow', 'Violet'];

        $detail = new Collection();
        if($i >= count($bg))
            $i = count($bg) % 5;

        $detail->bg = $bg[$i];
        $detail->pointer = $pointer[$i];
        
        return $detail;
    }
    function getCategoriesAsArray($type)
    {
        $cat = QCategory::where('type', $type)
                    -> latest('id')
                    -> get();

        $categories = [];

        foreach($cat as $det)
            $categories = array_merge($categories, [$det->name]);

        return $categories;
    }
    function randomAttributes($number)
    {
        $attributes = [];

        for($i = 0; $i < $number; $i++)
            $attributes = array_merge($attributes, [random_int(0, 0)]);

        return $attributes;
    }

    function getDetails($period, $type, $user)
    {
        if(!isset($period->beginEval))
            return null;
            
        $rawAtt = [];
        $lowestAttribute = 0;
        //get all categories
        $category = QCategory::where('type', $type)
                            -> latest('id')
                            -> get();
        //get all categories
        foreach($category as $det)
            $rawAtt[$det->id] = 0;

        $evaluation = new Collection();
        //get evaluations of user
        if(!isset($user))
            $user = auth()->user()->faculties->first();
        
        if($type == 3)
        {
            $heads = Faculty::where('department_id', $user->department_id)
                        -> latest('id')
                        -> get();
            $head = [];

            if($heads->isEmpty())
                return null;
            else
            {
                foreach($heads as $h)
                    $head = array_merge($head, [$h->user_id]);
            }

            $evaluation = Evaluate::where('evaluatee', $user->user_id)
                            -> whereIn('evaluator', $head)
                            -> where('period_id', $period->id)
                            -> latest('id')
                            -> get();
        }
        else
        {
            //get students enrolled in selected semester
            $enrolled = Enrollment::where('period_id', $period->id)
                                -> latest('id')
                                -> get();
            
            $students = [];

            if($enrolled->isEmpty())
                return null;
            else
            {
                foreach($enrolled as $det)
                    $students = array_merge($students, [$det->user_id]);
            }

            $evaluation = Evaluate::with('evalDetails')
                            -> where('evaluatee', $user->user_id)
                            -> whereIn('evaluator', $students)
                            -> where('period_id', $period->id)
                            -> latest('id')
                            -> get();
        }
        //randomize if mempty
        if($evaluation->isEmpty())
            return null;
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
                        if($prevCat != $detail->question->qcat->id && $prevCat != 0)
                        {
                            $final = $catPts / $catCount;

                            $rawAtt[$prevCat] = $rawAtt[$prevCat] == 0? round($final, 2) : round(($rawAtt[$prevCat] + $final) / 2, 2);
                        
                            if($lowestAttribute == 0)
                                $lowestAttribute = $prevCat;
                            
                            if($rawAtt[$prevCat] < $rawAtt[$lowestAttribute])
                                $lowestAttribute = $prevCat;

                            $catCount = 0;
                            $catPts = 0;
                        }
                        //sets previous category
                        $prevCat = $detail->question->qcat->id;

                        if($prevCat == $detail->question->qcat->id || $prevCat == 0)
                        {
                            $catPts += $detail->answer;
                            $catCount += 1;
                        }
                    }
                }
                //continue reads the last uncounted pts
                if($catPts != 0)
                {
                    $final = $catPts / $catCount;
                    $rawAtt[$prevCat] = $rawAtt[$prevCat] == 0? round($final, 2) : round(($rawAtt[$prevCat] + $final) / 2, 2);
                        
                    if($lowestAttribute == 0)
                        $lowestAttribute = $prevCat;
                    
                    if($rawAtt[$prevCat] < $rawAtt[$lowestAttribute])
                        $lowestAttribute = $prevCat;

                    $catCount = 0;
                    $catPts = 0;
                }
            }
        }
        $attributes = array();
        $attributes = array_merge($attributes, $rawAtt);

        $details = new Collection();

        $details->attributes = $attributes;
        $details->lowestAttribute = $lowestAttribute;
        
        return $details;
    }

    function getSummary($period, $type)
    {
        if(!isset($period->beginEval))
            return null;
        //get all categories
        $category = QCategory::where('type', $type)
                            -> latest('id')
                            -> get();

        $evaluation = new Collection();
        //get evaluations of user
        if($type == 3)
        {
            $heads = Faculty::where('department_id', auth()->user()->faculties->first()->department_id)
                        -> latest('id')
                        -> get();
            $head = [];

            if($heads->isEmpty())
                return null;
            else
            {
                foreach($heads as $h)
                    $head = array_merge($head, [$h->user_id]);
            }

            $evaluation = Evaluate::where('evaluatee', auth()->user()->id)
                            -> whereIn('evaluator', $head)
                            -> where('period_id', $period->id)
                            -> latest('id')
                            -> get();
        }
        else
        {
            //get students enrolled in selected semester
            $enrolled = Enrollment::where('period_id', $period->id)
                                -> where('status', 'Approved')
                                -> latest('id')
                                -> get();
            
            $students = [];

            if($enrolled->isEmpty())
                return null;
            else
            {
                foreach($enrolled as $det)
                    $students = array_merge($students, [$det->user_id]);
            }

            $evaluation = Evaluate::with('evalDetails')
                            -> where('evaluatee', auth()->user()->id)
                            -> whereIn('evaluator', $students)
                            -> where('period_id', $period->id)
                            -> latest('id')
                            -> get();
        }

        $summary = new Collection();
        //get the questions
        if($evaluation->isEmpty())
            return null;
        else
        {
            foreach($category as $det)
            {
                foreach($det->questions as $q)
                    $summary->push($q);
            } 

            foreach($evaluation as $det)
            {
                foreach($det->evalDetails as $detail)
                {
                    if($detail->question->q_type_id == 1)
                        $summary->where('id', $detail->question_id) ->first()->mean = isset($summary->where('id', $detail->question_id)->first()->mean)? ($summary->where('id', $detail->question_id)->first()->mean + $detail->answer) / 2 : $detail->answer;
                    else
                        $summary->where('id', $detail->question_id)->first()->message = isset($summary->where('id', $detail->question_id)->first()->message)?  $summary->where('id', $detail->question_id)->first()->message = array_merge( $summary->where('id', $detail->question_id)->first()->message, [$detail->answer]) : [$detail->answer];
                }
            }
        }

        return $summary;
    }
}
