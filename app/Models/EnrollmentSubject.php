<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentSubject extends Model
{
    use HasFactory;

    protected $fillable = ['enrollment_detail_id', 'subject_id'];
    //user relationship
    public function enrollDetail()
    {
        return $this->belongsTo(EnrollmentDetail::class, 'enrollment_detail_id');
    }
    //enrollment relationship
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}