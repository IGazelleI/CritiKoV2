<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'department_id', 
        'name', 
        'description', 
        'status'
    ];

    //department relationship
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    //student relationship
    public function students()
    {
        return $this->hasMany(Student::class, 'course_id');
    }
    //subject relationship
    public function subjects()
    {
        return $this->hasMany(Subject::class, 'course_id');
    }
}
