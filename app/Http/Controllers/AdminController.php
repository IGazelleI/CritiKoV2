<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Faculty;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\QCategory;
use App\Models\Department;
use App\Models\Enrollment;
use App\Charts\FacultyChart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Show the report page.
     *
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        //previous limit
        $prevLimit = Session::get('prevLimit') == null? 1 : Session::get('prevLimit');
        //get period selected
        $perSelected = isset($request->period)? decrypt($request->period) : null;
        //all periods
        $periodAll = Period::latest('id')
                        -> get();
        //if there is period selected then select that period else  select latest
        $period = isset($perSelected)? $periodAll->where('id', $perSelected)->first() : $periodAll->first();
        //get departments
        $department = Department::latest('id')
                                -> get();
        
        $deptSelected = isset($request->department)? decrypt($request->department) : null;
        //get faculties all faculties
        $faculty = Faculty::where(function ($query) use ($deptSelected)
                        {
                            if($deptSelected != null)
                            {
                                $query->where('department_id', $deptSelected);
                            }
                        })
                        -> latest('id')
                        -> get();

        if(!$faculty->isEmpty())
        {
            foreach($faculty as $det)
            {
                //get report from faculty evaluations
                $facultyChart[$det->id] = new FacultyChart();
                $facultyChart[$det->id]->options([
                    'min' => 0,
                    'max' => 100,
                    'backgroundColor' => $this->colors(0)->bg, 
                    'pointBorderColor' => $this->colors(0)->pointer,
                    'scales' => [
                        'r' => [
                            'min' => 0,
                            'max' => 100,
                            'ticks' => [
                                'stepSize' => 20,
                                'display' => false
                            ]
                    ]],
                    'responsive' => true
                ]);
                //get current attributes
                $details = $this->getDetails($period, 3, $det);
                //get the recommendations
                $recommendation[$det->id] = isset($details)? Question::select('keyword')
                                                -> where('q_category_id', $details->lowestAttribute)
                                                -> where('q_type_id', 1)
                                                -> latest('id')
                                                -> get() : null;
                //chart details
                $cat = $this->getCategoriesAsArray(3);
                $facultyChart[$det->id]->labels($cat)
                    -> dataset($period->getDescription(), 'radar', $details == null? $this->randomAttributes(count($cat)) : $details->attributes);

                //Select all previous evaluations
                $periods = $periodAll->where('id', '<', $period->id);

                $averageFac[$det->id] = 0;
                $prevAvgFac[$det->id] = 0;
                
                if(!$periods->isEmpty())
                {
                    $i = 1;
                    foreach($periods as $p)
                    {
                        if($i <= $prevLimit)
                        {
                            $prevDetails = $this->getDetails($p, 3, $det);
                        
                            if($prevDetails == null)
                            {
                                $random = $this->randomAttributes(count($cat));
                                $facultyChart[$det->id]->dataset($p->getDescription(), 'radar', $random)->options(['backgroundColor' => $this->colors($i)->bg, 'pointBorderColor' => $this->colors($i)->pointer]);
                                $prevAvgFac[$det->id] = $prevAvgFac[$det->id] == 0? collect($random)->avg() : ($prevAvgFac[$det->id] + collect($random)->avg()) / 2;
                            }
                            else
                            {
                                $facultyChart[$det->id]->dataset($p->getDescription(), 'radar', $prevDetails->attributes)->options(['backgroundColor' => $this->colors($i)->bg, 'pointBorderColor' => $this->colors($i)->pointer]);
                                $prevAvgFac[$det->id] = $prevAvgFac[$det->id] == 0? collect($prevDetails->attributes)->avg() : ($prevAvgFac[$det->id] + collect($prevDetails->attributes)->avg()) / 2;
                            }
                        }
                        else
                            break;

                        $i += 1;
                    }
                }

                if($details == null)
                    $averageFac[$det->id] = random_int(0, 0);
                else
                    $averageFac[$det->id] = collect($details->attributes)->avg();
                
                //get report from student
                $studentChart[$det->id] = new FacultyChart();
                $studentChart[$det->id]->options([
                    'min' => 0,
                    'max' => 100,
                    'backgroundColor' => $this->colors(0)->bg, 
                    'pointBorderColor' => $this->colors(0)->pointer,
                    'scales' => [
                        'r' => [
                            'min' => 0,
                            'max' => 100,
                            'ticks' => [
                                'stepSize' => 20,
                                'display' => false
                            ]
                    ]],
                    'responsive' => true
                ]);
                
                $details = $this->getDetails($period, 4, $det);

                if(isset($recommendation[$det->id]))
                {
                    $additional = isset($details)? Question::select('keyword')
                                        -> where('q_category_id', $details->lowestAttribute)
                                        -> where('q_type_id', 1)
                                        -> latest('id')
                                        -> get() : null;
                    if($additional != null)
                        $recommendation[$det->id] = $additional->concat($recommendation[$det->id]);
                }
                else
                {
                    $recommendation[$det->id] = isset($details)? Question::select('keyword')
                                        -> where('q_category_id', $details->lowestAttribute)
                                        -> where('q_type_id', 1)
                                        -> latest('id')
                                        -> get() : null;
                }

                //chart details
                $cat = $this->getCategoriesAsArray(4);
                $studentChart[$det->id]->labels($cat)
                    -> dataset($period->getDescription(), 'radar', $details == null? $this->randomAttributes(count($cat)) : $details->attributes);

                //Select all previous evaluations
                $periods = $periodAll->where('id', '<', $period->id);
                
                $averageSt[$det->id] = 0;
                $prevAvgSt[$det->id] = 0;
                if(!$periods->isEmpty())
                {
                    $i = 1;
                    foreach($periods as $p)
                    {
                        if($i <= $prevLimit)
                        {
                            $prevDetails = $this->getDetails($p, 4, $det);
                        
                            if($prevDetails == null)
                            {
                                $random = $this->randomAttributes(count($cat));
                                $studentChart[$det->id]->dataset($p->getDescription(), 'radar', $this->randomAttributes(count($cat)))->options(['backgroundColor' => $this->colors($i)->bg, 'pointBorderColor' => $this->colors($i)->pointer]);
                                $prevAvgSt[$det->id] = $prevAvgSt[$det->id] == 0? collect($random)->avg() : ($prevAvgSt[$det->id] + collect($random)->avg()) / 2;
                            }
                            else
                            {
                                $studentChart[$det->id]->dataset($p->getDescription(), 'radar', $prevDetails->attributes)->options(['backgroundColor' => $this->colors($i)->bg, 'pointBorderColor' => $this->colors($i)->pointer]);
                                $prevAvgSt[$det->id] = $prevAvgSt[$det->id] == 0? collect($prevDetails->attributes)->avg() : ($prevAvgSt[$det->id] + collect($prevDetails->attributes)->avg()) / 2;
                            }
                        }
                        else
                            break;

                        $i += 1;
                    }
                }

                if($details == null)
                    $averageSt[$det->id] = random_int(0, 0);
                else
                    $averageSt[$det->id] = collect($details->attributes)->avg();
            }
        }
        else
        {
            return view('admin.report', compact('periodAll', 'perSelected', 'department', 'deptSelected', 'faculty'));
        }

        return view('admin.report', compact('periodAll', 'perSelected', 'department', 'deptSelected', 'faculty', 'facultyChart', 'averageFac', 'prevAvgFac', 'studentChart', 'averageSt', 'prevAvgSt', 'recommendation'));
    }
    //change previous limit of the admin
    public function changePrevLimit(Request $request)
    {
        $request->session()->put('prevLimit', (int) $request->prevLimit);

        return back()->with('message', 'Limit in viewing previous semester changed.');
    }
    public function summary(Request $request)
    {
        $search = $request->search;
        $variables = ['search'];

        if(isset($search))
        {
            $faculty = Faculty::with('department')
                        -> where('fname', 'like', '%' . $search . '%')
                        -> orwhere('mname', 'like', '%' . $search . '%')
                        -> orwhere('lname', 'like', '%' . $search . '%')
                        -> latest('id')
                        -> get();

            $variables = array_merge($variables, ['faculty']);
        }

        return view('admin.summary', compact($variables));
    }
    public function summarySearch(Request $request)
    {
        $search = $request->search;

        return redirect(route('admin.summary', ['search' => $search]));
    }
    public function summaryReport(Request $request)
    {
        $faculty = Faculty::find($request->faculty);

        if($faculty == null)
            return back()->with('message', 'Faculty not found.');

        $periods = Period::latest('id')->get();
        $perSelected = $request->period;

        $summaryS = $this->getSummary(isset($request->period)? $periods->find($perSelected) : $periods->first(), 4, $faculty);
        $summaryF = $this->getSummary(isset($request->period)? $periods->find($perSelected) : $periods->first(), 3, $faculty);

        return view('admin.summaryReport', compact('faculty', 'periods', 'perSelected', 'summaryS', 'summaryF'));
    }
    //local methods
    function colors($i)
    {
        $bg = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(153, 102, 255, 0.2)'];
        $pointer = ['Red', 'Blue', 'Orange', 'Yellow', 'Violet'];

        $detail = new Collection();

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
    function getDetails($period, $type, $faculty)
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
        if($type == 3)
        {
            $evaluation = Evaluate::with('evalDetails')
                            -> where('evaluatee', $faculty->user_id)
                            -> where('evaluator', $faculty->department->faculties->where('isChairman', true)->first()->user_id)
                            -> whereDate('created_at', '>=', $period->beginEval)
                            -> whereDate('created_at', '<=', $period->endEval)
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
                            -> where('evaluatee', $faculty->user_id)
                            -> whereIn('evaluator', $students)
                            -> whereDate('created_at', '>=', $period->beginEval)
                            -> whereDate('created_at', '<=', $period->endEval)
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
                            $final = ($catPts / ($catCount * 5)) * 100;

                            $rawAtt[$prevCat] = $rawAtt[$prevCat] == 0? round($final, 0) : round(($rawAtt[$prevCat] + $final) / 2, 0);
                        
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
                    $final = ($catPts / ($catCount * 5)) * 100;
                    $rawAtt[$prevCat] = $rawAtt[$prevCat] == 0? round($final, 0) : round(($rawAtt[$prevCat] + $final) / 2, 0);
                        
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
    function getSummary($period, $type, $faculty)
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
            $heads = Faculty::where('department_id', $faculty->department_id)
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

            $evaluation = Evaluate::where('evaluatee', $faculty->user_id)
                            -> whereIn('evaluator', $head)
                            -> whereDate('created_at', '>=', $period->beginEval)
                            -> whereDate('created_at', '<=', $period->endEval)
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
                            -> where('evaluatee', $faculty->user_id)
                            -> whereIn('evaluator', $students)
                            -> whereDate('created_at', '>=', $period->beginEval)
                            -> whereDate('created_at', '<=', $period->endEval)
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
                        $summary->where('id', $detail->question_id)->first()->mean = isset($summary->where('id', $detail->question_id)->first()->mean)? ($summary->where('id', $detail->question_id)->first()->mean + $detail->answer) / 2 : $detail->answer;
                    else
                        $summary->where('id', $detail->question_id)->first()->message = isset($summary->where('id', $detail->question_id)->first()->message)?  $summary->where('id', $detail->question_id)->first()->message = array_merge( $summary->where('id', $detail->question_id)->first()->message, [$detail->answer]) : [$detail->answer];
                }
            }
        }

        return $summary;
    }
}
