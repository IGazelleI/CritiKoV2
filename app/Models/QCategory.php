<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'status'
    ];
    //question relationship
    public function questions()
    {
        return $this->hasMany(Question::class, 'q_category_id');
    }
}
