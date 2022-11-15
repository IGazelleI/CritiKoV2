<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //role
    public function role()
    {
        switch($this->type)
        {
            case 1: return 'admin';
                    break;
            case 2: return 'sast';
                    break;
            case 3: return 'faculty';
                    break;
            case 4: return 'student';
                    break;
            
            default: return false;
        }
    }
    //student relationship
    public function students()
    {
        return $this->hasMany(Student::class, 'user_id');
    }
    //faculty relationship
    public function faculties()
    {
        return $this->hasMany(Faculty::class, 'user_id');
    }
    //admin relationship
    public function admins()
    {
        return $this->hasMany(Admin::class, 'user_id');
    }
    //evaluate relationship
    public function evaluates()
    {
        return $this->hasMany(Evaluate::class, 'evaluator');
    }
}
