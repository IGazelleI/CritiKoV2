<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Evaluate;
use App\Models\Question;
use App\Models\QCategory;
use App\Models\Department;
use App\Models\Enrollment;
use App\Charts\FacultyChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePicRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\FacultyStoreRequest;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('faculty.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $det = Faculty::with('user')
                    -> where('user_id', '=', auth()->user()->id)
                    -> get()
                    -> first();

        return view('faculty.profile', compact('det'));
    }

    public function update(FacultyStoreRequest $request)
    {
        if(!Faculty::updateInfo($request->all()))
            return back()->with('message', 'Error in updating profile. Please try again');

        return back()->with('message', 'Profile updated.');
    }

    public function changeProfilePicture(ChangePicRequest $request, Faculty $faculty)
    {
        $name = encrypt($faculty->id) . '.' . $request->file('imgPath')->getClientOriginalExtension();
        $request->file('imgPath')->storeAs('public/images', $name);
        //update img
        $faculty->imgPath = $name;

        if(!$faculty->save())
            return back()->with('message', 'Error in updating profile. Please try again.');

        return back()->with('message', 'Profile picture updated.');
    }

    public function changePeriod(Request $request)
    {
        $request->session()->put('period', (int) $request->period);

        return back()->with('message', 'Period changed.');
    }

    public function enrollment()
    {
        $courses = Department::find(auth()->user()->faculties[0]->department_id)
                                -> courses;
        
        $enrollment = new Collection;
        $i = 0;

        foreach($courses as $det)
        {
            $enrolls = $det->enrollments
                        -> where('status', '=', 'Pending')
                        -> where('period_id', Session::get('period'));
            foreach($enrolls  as $cat)
            {
                $enrollment[$i] = $cat;
                $i += 1;
            }
        }

        return view('dean.enrollment', compact('enrollment'));
    }

    public function processEnrollment(Request $request, Enrollment $enroll)
    {
        $status = $request->decision? 'Approved' : 'Denied';

        if(!DB::table('enrollments')
            -> where('id', $enroll->id)
            -> update(['status' => $status])
        )
            return back()->with('message', 'Error in updating enrollment.');

        if(!Enrollment::process($request->all(), $enroll))
        {
            if(!DB::table('enrollments')
                -> where('id', '=', $enroll->id)
                -> update(['status' => 'Pending'])
            )
                return back()->with('message', 'Error in updating enrollment.');
        }

        return back()->with('message', 'Enrollment ' . $status . '.');
    }

    public function evaluate(Request $request)
    {
        $period = Period::find(Session::get('period'));

        $question = Question::with('qType')
                        -> with('qCat')
                        -> where('type', 3)
                        -> orderBy('q_type_id')
                        -> orderBy('q_category_id')
                        -> get();

        $faculty = Faculty::where('department_id', auth()->user()->faculties[0]->department_id)
                        -> where('user_id', '!=', auth()->user()->id)
                        -> latest('id')
                        -> get();

        if(isset($request->faculty))
            $request->session()->put('selected', (int) decrypt($request->faculty));

        $currentSelected = Session::get('selected');

        $evaluation = $currentSelected != null? Evaluate::where('evaluator', auth()->user()->id)
                                                        -> where('evaluatee', $currentSelected)
                                                        -> where('period_id', Session::get('period'))
                                                        -> latest('id')
                                                        -> get()
                                                        -> first() : null;

        return view('faculty.evaluate', compact('period', 'question', 'faculty'));
    }

    public function evaluateProcess(Request $request)
    {
        if(!Faculty::storeEvaluate($request->all()))
            return back()->with('message', 'Error in submitting evaluation.');

        return redirect(route('faculty.evaluate'))->with('message', 'Evaluation submitted.');
    }

    public function changeSelected(Request $request)
    {
        $request->session()->put('selected', (int) $request->user_id);

        return redirect(route('faculty.evaluate'))->with('message', 'Selected changed.');
    }

    public function report()
    {
        //get current period
        $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period')); 
        //get faculties under department
        $faculty = Faculty::where('department_id', auth()->user()->faculties[0]->id)
                        -> where('user_id', '!=', auth()->user()->id)
                        -> latest('id')
                        -> get();

        foreach($faculty as $det)
        {
            $chart[$det->id] = new FacultyChart();
            
            $labels = [];
            $rawAtt = [];
            $lowestAttribute = 0;
            $i = 0;
            //get all categories
            $category = QCategory::all();
            //get all categories
            foreach($category as $cat)
            {
                $labels[$i++] = $cat->name;
                $rawAtt[$cat->id] = 0;
            }

            $chart[$det->id]-> labels($labels);

            $period = Period::latest('id')
                        -> get();

            $color = 0;

            foreach($period as $p)
            {
                if(isset($p->beginEval))
                {
                    //get evaluations of user
                    $evaluation = Evaluate::where('evaluatee', $det->user_id)
                                    -> whereDate('created_at', '>=', $p->beginEval)
                                    -> whereDate('created_at', '<=', $p->endEval)
                                    -> latest('id')
                                    -> get();
                    //randomize if mempty
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
                                    /* dump($prevCat . ' ' . $detail->question->qcat->id); */

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
                                    }
                                }
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

                        /* $recommendation = Question::where('q_category_id', $lowestAttribute)
                                                -> where('q_type_id', 1)
                                                -> latest('id')
                                                -> get(); */
                                                    
                        $attributes = array();
                        $attributes = array_merge($attributes, $rawAtt);
                    }
                    $average[$det->id] = collect($attributes)->avg();
                    $prevAvg[$det->id] = collect($prevAtt)->avg();
                    //chart details
                    $chart[$det->id]-> dataset($p->getDescription(), 'radar', $attributes)
                        -> options([
                            'min' => 0,
                            'max' => 100,
                            'backgroundColor' => $this->colors($color),
                            'pointBorderColor' => $this->colors($color),
                            'scales' => [
                                'min' => 0,
                                'max' => 100,
                                'r' => [
                                    'suggestedMin' => 0,
                                    'suggestedMax' => 100,
                                ],
                                'ticks' => [
                                    'stepSize' => 20,
                                    'display' => false
                            ]
                        ],
                            'responsive' => true
                    ]);/* 
                    $chart[$det->id]-> dataset('Previous', 'radar', $prevAtt) 
                        -> options([
                            'min' => 0,
                            'max' => 100,
                            'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                            'pointBorderColor' => 'Red',
                            'scales' => [
                                'min' => 0,
                                'max' => 100,
                                'ticks' => [
                                    'stepSize' => 20,
                                    'display' => false
                            ]],
                            'responsive' => true
                    ]); */
                }
                $color += 1;
            }
            
        }

        return view('dean.facultyReport', compact('faculty', 'chart', 'average', 'prevAvg'));
    }
    function colors($i)
    {
        $bg = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'Green', 'Yellow', 'Gray'];
        
        return $bg[$i];
    }
}
