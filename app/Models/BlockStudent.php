<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlockStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'block_id', 
        'user_id',
        'status'
    ];
    //block relationship
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }
    //user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
