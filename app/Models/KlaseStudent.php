<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlaseStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'klase_id',
        'id_number',
        'status'
    ];
    //klase relationship
    public function klase()
    {
        return $this->belongsTo(Klase::class, 'klase_id');
    }
    //student relationship
    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }
}
