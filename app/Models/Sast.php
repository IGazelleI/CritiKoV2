<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sast extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'fname', 'mname', 'lname', 'suffix'];
}
