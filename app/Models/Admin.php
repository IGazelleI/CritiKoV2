<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'secret_key',
        'status'
    ];
    //user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
