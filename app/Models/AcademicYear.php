<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;
    
    protected $fillable = ['begin', 'end'];

    public function getDescription()
    {
        return $this->begin . '-' . $this->end;
    }
    //period relationship
    public function periods()
    {
        return $this->hasMany(Period::class, 'academic_year_id');
    }
}
