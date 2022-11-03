<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];
    //question relationship
    public function questions()
    {
        return $this->hasMany(Queestion::class, 'q_category_id');
    }
}
