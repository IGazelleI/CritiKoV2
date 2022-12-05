<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'suffix',
        'user_id',
        'department_id',
        'isDean', 
        'status'
    ];

    public function fullName($iniMid)
    {
        return ucfirst($this->fname) . ' ' . 
               (empty($this->mname)? '' : (($iniMid)? ucfirst($this->mname[0]) . '.' : ucfirst($this->mname))) . ' ' .
               ucfirst($this->lname) . ' ' . 
               (empty($this->suffix)? '' : ucfirst($this->suffix) .'.' );
    }
    //update studnet information
    public static function updateInfo($request)
    {
        $userID = $request['user_id'];

        Arr::forget(
            $request, [
                '_token',
                '_method'
            ]
        );

        $result = DB::table('faculties')
                    -> where('user_id', $userID)
                    -> update($request);

        return $result;
    }
    //store evaluate
    public static function storeEvaluate($request)
    {
        $eval = Evaluate::create([
            'period_id' => Session::get('period'),
            'evaluator' => auth()->user()->id,
            'evaluatee' => Session::get('selected')
        ]);

        if(!$eval)
            return back()->with('message', 'Error in creating evaluation.');

        //update faculty points
        $prevCat = 0;
        $catPts = 0;
        $catCount = 0;

        //insert the eval dets
        for($i = 1; $i <= $request['totalQuestion']; $i++)
        {
            //insert to evaluation details table
            if(!EvaluateDetail::create([
                'question_id' => $request['qID' . $i],
                'answer' => $request['qAns' . $i],
                'evaluate_id' => $eval->id
            ]))
                return back()->with('message', 'Error in creating evalation detail.');
            /* //update attribute of evaluatee based on points
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
            } */
            //get points from evaluation
            if(isset($request['qCatID' . $i]))
            {
                if($prevCat == $request['qCatID' . $i])
                {
                    $catPts += (int) $request['qAns' . $i];

                    $catCount++;
                }
                
                $prevCat = $request['qCatID' . $i];
            }
        }

        return true;
    }
    //profile picture path
    public function imgPath()
    {
        return 'storage/images/' . $this->imgPath;
    }
    //user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //department relationship
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    //klase relationship
    public function klases()
    {
        return $this->hasMany(Klase::class, 'instructor', 'user_id');
    }
    //evaluate relationship
    public function evaluated()
    {
        return $this->hasMany(Evaluate::class, 'evaluatee', 'user_id');
    }
}
