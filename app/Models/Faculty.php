<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        return $this->hasMany(Klase::class, 'instructor');
    }
}
