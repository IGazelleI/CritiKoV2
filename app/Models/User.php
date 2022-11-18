<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
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

    public static function createByRole($request, $userID)
    {
        if($request['type'] != 1)
        {
            $formFields = [
                'user_id' => $userID,
                'fname' => $request['fname'],
                'mname' => $request['mname'],
                'lname' => $request['lname'],
                'suffix' => $request['suffix']
            ];
        }
        switch($request['type'])
        {
            case 1: while(!Admin::create([
                        'user_id' => $userID
                    ])){}
                    
                    break;
            case 2: while(!Sast::create($formFields)){}

                    break;
            case 3: $formFields['department_id'] = $request['department_id'];

                    while(!Faculty::create($formFields)){}

                    break;
            case 4: $formFields['course_id'] = $request['course_id'];
                
                    while(!Student::create($formFields)){}
                    break;
        }

        return true;
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
