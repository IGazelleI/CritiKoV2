<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'day',
        'begin',
        'end',
        'subject_id',
        'block_id',
        'instructor',
        'status'
    ];
    
    public function schedule()
    {
        return substr($this->day, 0, 3) . ' @ ' . date('g:i A', strtotime($this->begin)) . '-' . date('g:i A', strtotime($this->end));
    }
    //subject relationshio
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    //block relatinoship
    public function block()
    {
        return $this->belongsTo(Block::class, 'block_id');
    }
    //faculty relationship
    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'user_id', 'instructor');
    }
    //klase student relationship
    public function klaseStudents()
    {
        return $this->hasMany(KlaseStudent::class, 'klase_id');
    }
}
