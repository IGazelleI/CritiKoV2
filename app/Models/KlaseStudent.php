<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlaseStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'klase_id',
        'user_id',
        'id_number',
        'status'
    ];
    //klase relationship
    public function klase()
    {
        return $this->belongsTo(Klase::class, 'klase_id');
    }
    //user relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
