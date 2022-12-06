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
            case 1:
                //chart
                $chart = new FacultyChart();

                $chart-> labels(['One', 'Two', 'Three', 'Four'])
                    -> dataset('Chart Name', 'line', [50, 20, 70, 15]);
                
                return view('admin.index', compact('chart'));
                break;
            case 2:
                //percentage done chart
                $chart = new FacultyChart();
                //chart details
                $chart-> labels(['Pending', 'Finished'])
                    -> dataset('Chart Name', 'doughnut', [50, 20])
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
                //get enrollment query
                $enrollment = Enrollment::latest('id')
                                    -> get();
                //total enrollee
                $totalEnrollee  = $enrollment->count();
                //number of finished evaluations
                $finished = 0;
                
                foreach($enrollment as $det)
                    $finished += $det->user->evaluates->count();

                //number of evaluations when completed
                $expected = 0;

                foreach($enrollment as $det)
                    $expected += $det->user->klaseStudent->klase->block->klases->count();
                
                //pending
                $pending = $expected - $finished;

                return view('sast.index', compact('chart', 'totalEnrollee', 'finished', 'pending', 'expected'));
                break;
            case 3: 
                //attributes chart 
                $chart = new FacultyChart();

                $labels = [];
                $attributes = [];
                $lowestAttribute = 0;
                $i = 0;
                //get all categories
                $category = QCategory::all();
                //get all categories
                foreach($category as $det)
                {
                    $labels[$i] = $det->name;
                    $attributes[$i++] = 0;
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
                    //get statistics based on evaluation
                    foreach($evaluation as $det)
                    {
                        $catCount = 0;
                        $catPts = 0;
                        $prevCat = 0;

                        foreach($det->evalDetails as $detail)
                        {
                            //only gets the quantitative question
                            if($detail->question->q_type_id == 1)
                            {
                                //update current points
                                if($prevCat == $detail->question->qcat->id - 1)
                                {
                                    $catPts += $detail->answer;
                                    $catCount += 1;
                                }
                                //get the points by percent
                                if($prevCat != $detail->question->qcat->id - 1)
                                {
                                    $final = ($catPts / ($catCount * 5)) * 100;

                                    $attributes[$prevCat] = $attributes[$prevCat] == 0? round($final, 0) : round($attributes[$prevCat] + $final / 2, 0);

                                    if($attributes[$prevCat] < $attributes[$lowestAttribute])
                                        $lowestAttribute = $prevCat;

                                    dump( //BUANG PA ANG CHART SA DEAN
                                            'Previous Category: ' . $prevCat .
                                            ' Current Answer: ' . $detail->answer .
                                            ' Total: ' . $catPts .
                                            ' Overall: ' . ($catCount * 5) .
                                            ' Current Attribute: ' . $attributes[$detail->question->qcat->id - 1] .
                                            ' Final:  ' . $final .
                                            ' Final of ' . $detail->question->qcat->name . ': ' . $attributes[$prevCat]
                                        );
                                        dump($attributes);
                                        dump('Current: ' . $attributes[$prevCat] . ' Lowest: ' . $attributes[$lowestAttribute] . ' ' . $lowestAttribute);
                                    $catPts = 0;
                                    $catCount = 0;
                                }

                                $prevCat = $detail->question->qcat->id - 1;
                            } 
                        }
                        dump($lowestAttribute);
                        $recommendation = Question::where('q_category_id', $lowestAttribute + 1)
                                                -> where('q_type_id', 1)
                                                -> latest('id')
                                                -> get();
                    }
                }
                //chart details
                $chart-> labels($labels)
                    -> dataset('Latest', 'radar', $attributes)
                    -> options([
                    'pointBorderColor' => 'Blue',
                    'scales' => [
                        'r' => [
                        'min' => 50,
                        'max' => 100,
                        'ticks' => [
                            'stepSize' => 20,
                            'display' => false
                    ]]],
                    'responsive' => true
                ]);
                //get current period
                $period = Session::get('period') == null? Period::latest('id')->get()->first() : Period::find(Session::get('period'));
                //get faculties in same department
                $faculty = Faculty::where('department_id', auth()->user()->faculties[0]->department_id)
                            -> where('user_id', '!=', auth()->user()->id)
                            -> latest('id')
                            -> get();
                
                return view('faculty.index', compact('period', 'faculty', 'chart', 'recommendation'));
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
