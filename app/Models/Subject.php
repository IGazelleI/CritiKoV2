<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 
        'name', 
        'descriptive_title', 
        'year_level', 
        'semester', 
        'status'
    ];
    //course relationship
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
