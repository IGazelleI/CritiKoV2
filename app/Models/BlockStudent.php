<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockStudent extends Model
{
    use HasFactory;

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
    //student relationship
    public function student()
    {
        return $this->hasMmany(Student::class, 'user_id');
    }
}
