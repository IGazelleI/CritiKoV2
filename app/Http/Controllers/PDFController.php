<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Evaluate;
use App\Models\QCategory;
use App\Models\Enrollment;
use App\Models\Klase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PDFController extends Controller
{
    public function view(Period $period, $type, Faculty $faculty)
    {
        $data = $this->getSummary($period, $type, $faculty);

        if(($type != 3 && $type != 4) || $data == null)
            abort(404);

        /* $subject = $faculty->klases;  */
        $pdf = $type == 3? PDF::loadview('pdf.facultyReport', array('type' =>  $type, 'faculty' => $faculty, /* 'subject' => $subject, */ 'period' => $period, 'data' => $data)) : 
                           PDF::loadview('pdf.studentReport', array('type' =>  $type, 'faculty' => $faculty, /* 'subject' => $subject, */ 'period' => $period, 'data' => $data))
                                -> setPaper('letter', 'landscape');

        return $pdf->stream();
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
                            -> where('evaluatee', $faculty->user_id)
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
