<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'description', 
        'status'
    ];
    //course relationship
    public function courses()
    {
        return $this->hasMany(Course::class, 'department_id');
    }
    //faculty relationship
    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'department_id');
    }
}
