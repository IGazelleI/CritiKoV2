<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status'
    ];
    //question relationship
    public function questions()
    {
        return $this->hasMany(Queestion::class, 'q_type_id');
    }
}
