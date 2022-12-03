<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluate extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_id',
        'evaluator',
        'evaluatee'
    ];
    //evaluator relationship
    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator');
    }
    //evaluatee relationship
    public function evaluatee()
    {
        return $this->belongsTo(User::class, 'evaluatee');
    }
    //EvalDet relationship
    public function evalDetails()
    {
        return $this->hasMany(EvaluateDetail::class, 'evaluate_id');
    }
}
