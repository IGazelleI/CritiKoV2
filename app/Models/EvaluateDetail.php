<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluateDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'evaluate_id',
        'question_id',
        'answer'
    ];
    //evaluation relationship
    public function evaluate()
    {
        return $this->hasMany(Evaluate::class, 'evaluate_id');
    }
    //question relationship
    public function question()
    {
        return $this->hasMany(Question::class, 'question_id');
    }
}
