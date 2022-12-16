<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentDetail extends Model
{
    use HasFactory;

    protected $fillable = ['enrollment_id'];
    //enrollment relationship
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'enrollment_id');
    }
    //enrollment detail relationship
    public function enrollSubjects()
    {
        return $this->hasMany(EnrollmentSubject::class, 'enrollment_detail_id');
    }
}
