<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Period extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
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
        if($this->semester == 1)
        {
            //beginning of academic year
            $begin = $this->begin;
            //end of academimc year
            $next = Period::where('id', '>', $this->id)
                        -> where('semester', '>', $this->semester)
                        -> get()
                        -> first();

            $end = isset($next)? $next->end : $this->end;
        }
        else
        {
            //begin of academic year
            $previous = Period::where('id', '<', $this->id)
                        -> where('semester', '<', $this->semester)
                        -> latest('id')
                        -> get()
                        -> first();

            $begin = isset($previous)? $previous->begin : $this->begin;
            //end of academic year
            $end = $this->end;
        }

        return self::str_ordinal($this->semester) . " Semester SY " . date('Y', strtotime($begin)) . '-' . date('Y', strtotime($end));
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
}
