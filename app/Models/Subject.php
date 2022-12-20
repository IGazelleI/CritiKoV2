<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'code',
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
    //klase relationship
    public function klase()
    {
        return $this->hasMany(Klase::class, 'subject_id');
    }
}
