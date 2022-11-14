<?php

use App\Models\EvalDet;
use App\Models\Evaluation;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function store($request)
    {
        $eval = Evaluation::create([
            'evaluator' => auth()->user()->id,
            'evaluatee' => $request['user_id']
        ]);

        if(!$eval)
            return back()->with('message', 'Error in creating evaluation.');

        //update faculty points
        $prevCat = 0;
        $catPts = 0;
        $catCount = 0;

        //insert the eval dets
        for($i = 1; $i <= $request->totalQuestion; $i++)
        {
            //insert to evaluation details table
            if(!EvalDet::create([
                'question_id' => $request['qID' . $i],
                'answer' => $request['qAns' . $i],
                'evaluation_id' => $eval->id
            ]))
                return back()->with('message', 'Error in creating evalation detail.');
            //update attribute of evaluatee based on points
            if($prevCat != $request['qCatID' . $i] && $prevCat != 0)
            {
                //get points of the current category of the faculty
                $points = Attribute::select('points')
                                -> where('q_category_id', '=', $prevCat)
                                -> where('faculty_id', '=', $eval->evaluatee)
                                -> get();

                foreach($points as $point)
                    $pts = $point->points;

                $pts = ($pts + (($catPts / ($catCount * 5)) * 100)) / 2;

                $details = [
                    'faculty_id' => $request['user_id'],
                    'q_category_id' => $prevCat,
                    'points' => $pts
                ];

                if(!DB::table('attributes')
                    -> where('faculty_id', '=', $details['faculty_id'])
                    -> where('q_category_id', '=', $details['q_category_id'])
                    -> update(['points' => $details['points']]))
                    return back()->with('message', 'Error in updating attribute');

                $catcount = 0;
                $catPts = 0;
            }
            //get points from evaluation
            if($prevCat == $request['qCatID' . $i])
            {
                $catPts += (int) $request['qAns' . $i];

                $catCount++;
            }

            $prevCat = $request['qCatID' . $i];
        }

        return true;
    }
}