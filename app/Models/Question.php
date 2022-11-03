<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'q_type_id',
        'q_category_id',
        'sentence',
        'keyword',
        'type',
        'status'
    ];
    //qtype relationship
    public function qType()
    {
        return $this->belongsTo(QType::class, 'q_type_id');
    }
    //qcat relationship
    public function qCat()
    {
        return $this->belongsTo(QCategory::class, 'q_category_id');
    }
    //evalDet relationship
    public function evalDetails()
    {
        return $this->hasMany(EvaluateDetail::class, 'question_id');
    }
}
