<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'academic_year_id',
        'semester',
        'begin',
        'end',
        'beginEnroll',
        'endEnroll',
        'beginEval',
        'endEval', 
        'status'
    ];

    public function getDescription()
    {
        return self::str_ordinal($this->semester) . " Semester SY " . $this->acadYear->getDescription();
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

    public function acadYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
}
