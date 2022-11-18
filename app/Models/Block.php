<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected  $fillable = [
        'period_id', 
        'course_id', 
        'year_level', 
        'section',
        'status,'
    ];
    public function getDescription()
    {
        return $this->course->name . ' ' . $this->year_level . '-' . $this->section;
    }
    //course relationship
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    //period relationship
    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
    //block student relationship
    public function blockStudents()
    {
        return $this->hasMany(BlockStudent::class, 'block_id');
    }
}
