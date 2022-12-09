<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_number', 
        'fname', 
        'mname', 
        'lname', 
        'suffix', 
        'gender',
        'address',
        'dob',
        'cnumber',
        'emergency_cPName',
        'emergency_cPNumber',
        'emergency_cPRelationship',
        'emergency_cPAddress',
        'status',
        'course_id',
        'user_id',
    ];
    //create student from user
    public static function createFromUser($request, $userID)
    {
        $request['user_id'] = $userID;

        return self::create($request->all());
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
        
        $result = DB::table('students')
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

    //display full name
    public function fullName($iniMid)
    {
        return ucfirst($this->fname) . ' ' . 
            (empty($this->mname)? '' : (($iniMid)? ucfirst($this->mname[0]) . '.' : ucfirst($this->mname))) . ' ' .
            ucfirst($this->lname) . ' ' . 
            (empty($this->suffix)? '' : ucfirst($this->suffix) .'.' );
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
    //course relationship
    public function courses()
    {
        return $this->hasMany(Course::class, 'id');
    }
    //enrollment relationship
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'user_id', 'user_id');
    }
    //blockstudent relationship
    public function blockStudent()
    {
        return $this->hasMany(BlockStudent::class, 'user_id');
    }
    //klase student relationship
    public function klaseStudent()
    {
        return $this->hasMany(KlaseStudent::class, 'user_id');
    }
}
