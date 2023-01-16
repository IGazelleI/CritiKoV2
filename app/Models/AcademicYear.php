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
}
