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
use Illuminate\Support\Collection;
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
        $courses = Department::find(auth()->user()->faculties->first()->department_id)
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

            return back()->with('message', 'There is a problem approving the enrollment. May be due to the lack of blocks currently have and an ireggular student cannot to the classes of a block.');
        }

        return back()->with('message', 'Enrollment ' . $status . '.');
    }

    public function evaluate(Request $request)
    {
        $period = Period::find(Session::get('period'));

        $cat = QCategory::with('questions')
                    -> where('type', 3)
                    -> latest('id')
                    -> get();

        $question = new Collection();

        foreach($cat as $det)
        {
            foreach($det->questions as $q)
                $question->push($q);
        }
        $question = $question->sortBy('q_type_id');
        
        $faculty = Faculty::where('department_id', auth()->user()->faculties->first()->department_id)
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

        return view('faculty.evaluate', compact('period', 'question', 'faculty', 'evaluation'));
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

    public function changePrevLimit(Request $request)
    {
        $request->session()->put('prevLimit', (int) $request->prevLimit);

        return back()->with('message', 'Limit in viewing previous semester changed.');
    }

    public function report()
    {
        //previous limit
        $prevLimit = Session::get('prevLimit') == null? 1 : Session::get('prevLimit');
        //get current period
        $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period')); 
        //get faculties under department
        $faculty = Faculty::where('department_id', auth()->user()->faculties[0]->id)
                        -> where('user_id', '!=', auth()->user()->id)
                        -> latest('id')
                        -> get();

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
            $periods = Period::where('id', '<', $period->id)
                        -> latest('id')
                        -> get();

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
            $periods = Period::where('id', '<', $period->id)
                        -> latest('id')
                        -> get();
            
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

        return view('dean.facultyReport', compact('faculty', 'facultyChart', 'averageFac', 'prevAvgFac', 'studentChart', 'averageSt', 'prevAvgSt', 'recommendation'));
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
                            -> where('evaluatee', $faculty)
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
}
