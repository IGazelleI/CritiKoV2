<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sast extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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
        'user_id'        
    ];
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
        
        $result = DB::table('sasts')
                    -> where('user_id', $userID)
                    -> update($request);

        return $result;
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
    //user relationshhip
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
