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

    public function getDescription($withCourse)
    {
        return (($withCourse)? $this->course->name  . ' ' : '') . $this->year_level . '-' . chr($this->section + 64);
    }

    public function getYear()
    {
        return self::str_ordinal($this->year_level) . ' Year';
    }

    public function str_ordinal($value)
    {
        $superscript = false;
        $number = abs($value);
 
        $indicators = ['th','st','nd','rd','th','th','th','th','th','th'];
 
        $suffix = $superscript ? '<sup>' . $indicators[$number % 10] . '</sup>' : $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = $superscript ? '<sup>th</sup>' : 'th';
        }
 
        return number_format($number) . $suffix;
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
    //klase relationship
    public function klases()
    {
        return $this->hasMany(Klase::class, 'block_id');
    }
}
