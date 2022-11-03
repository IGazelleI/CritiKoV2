<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

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
        'status',
        'course_id',
        'user_id', 
        'status'
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
    //display full name
    public function fullName()
    {
        return ucfirst($this->fname) . ' ' . (empty($this->mname)? '' : ucfirst($this->mname[0]) .'. ' ) . ucfirst($this->lname) . ' ' . (empty($this->suffix)? '' : ucfirst($this->suffix) .'.' );
    } 
    //user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //course relationship
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
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
