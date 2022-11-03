<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'suffix',
        'user_id',
        'department_id',
        'isDean', 
        'status'
    ];

    public function fullName()
    {
        return ucfirst($this->fname) . ' ' . ucfirst($this->mname(0)) . ' ' . ucfirst($this->lname);
    }
    //user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //department relationship
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    //klase relationship
    public function klases()
    {
        return $this->hasMany(Klase::class, 'instructor');
    }
}
