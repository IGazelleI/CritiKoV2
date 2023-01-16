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
        'chairman',
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
    //enrollment relationship
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id');
    }
    //block relationship
    public function blocks()
    {
        return $this->hasMany(Block::class, 'course_id');
    }
    //faculty relationship
    public function chairmann()
    {
        return $this->belongsTo(Faculty::class, 'chairman', 'user_id');
    }
}
