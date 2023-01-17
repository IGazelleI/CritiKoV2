<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Period;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Department;
use App\Models\Enrollment;
use Illuminate\Support\Str;
use App\Charts\FacultyChart;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class UserController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function store(UserStoreRequest $request)
    {
        $request->validate(['email' => 'email_domain:' . $request->email], ['email.email_domain' => 'Only CTU-provided emails allowed.']);
        $request['password'] = Hash::make($request->password);

        $user = User::create($request->all());

        if(!$user)
            return back()->with('message', 'Error in creating user. Try again later.');
        else
        {
            while(!Student::createFromUser($request, $user->id)){}
        }

        return redirect(route('index'))->with('message', 'Account registered.');
    }

    public function create(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email', Rule::unique('users', 'email'), 'email_domain:' . $request->email],
            'password' => 'required'
        ],[
            'email.required' => 'Email field is required.',
            'email.unique' => 'Email already exist.',
            'email.email_domain' => 'Only CTU-provided emails allowed.',
            'password.required' => 'Password field is required.'
        ]);

        if($request->type == 4)
        {
            $formFields = $request->validate([
                'id_number' => Rule::unique('students', 'id_number')
            ],[
                'id_number.unique' => 'ID number already exists.'
            ]);
        }

        $request['password'] = bcrypt($request->password);
        $user = User::create($request->all());

        if(!$user)
            return back()->with('message', 'Error in creating user. Try again later.');
        else
        {
            while(!User::createByRole($request->all(), $user->id)){}
        }

        return back()->with('message', 'Account added.');
    }
   
    public function auth(Request $request)
    {
        $formFields = $request->validate([
            'email_login' => ['required', 'email'],
            'password_login' => 'required'
        ],[
            'email_login.required' => 'Required',
            'password_login.required' => 'Required'
        ]);

        $auth['email'] = $formFields['email_login'];
        $auth['password'] = $formFields['password_login'];

        if(auth()->attempt($auth, $request->remember))
        {
            $request->session()->regenerate();

            return redirect(route('home'))->with('message', 'You are now logged in.');
        }
        else
            return back()->withErrors(['email_login' => 'Invalid login attempt'])->onlyInput('email');
    }

    public function resetPassword(Request $request)
    {
        $formFields = $request->validate([
            'password' => ['required', 'confirmed', 'min:6']
        ], [
            'password.required' => 'Password field is required.',
            'password.confirmed' => 'The password does not match.',
            'password.min' => 'The password must contain atleast 6 characters.'
        ]);
        $user = User::find($request->id);

        if(!$user->update([
            'password' => bcrypt($formFields['password'])
        ]))
            return back()->with('message', 'Error in resetting user password. Please try again.');

        return back()->with('message', 'User password resetted successfully.');
    }

    public function changePassword(Request $request)
    {
        $formFields = $request->validate([
            'currentPass' => 'required',
            'newPass' => ['required', 'confirmed', 'min:6']
        ],[
            'currentPass.required' => 'Please enter current password.',
            'newPass.required' => 'New password field is required.',
            'newPass.confirmed' => 'The new password does not match.',
            'newPass.min' => 'Password must have atleast 6 characters.'
        ]);

        if(Hash::check($formFields['currentPass'], auth()->user()->password))
        {
            $user = User::find(auth()->user()->id);

            if(!$user->update(['password' => bcrypt($formFields['newPass'])]))
                return back()->with('message', 'Error in updating new password. Please try again.');
        }
        else
            return back()->with('message', 'Current password is incorrect. Please try again.');

        return back()->with('message', 'Password changed.');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('index'))->with('message', 'You have been logged out.');
    }

    public function forgotPassword()
    {
        return view('user.forgot-password');
    }

    public function process(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                            ->with('message', 'Please check your email for the reset link.')
                    : back()->withErrors(['email' => __($status)]);
    }

    public function reset($token)
    {
        return view('user.reset-password', [
            'token' => $token
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password)
            {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('index')->with('status', __($status))
                                                ->with('message', 'Password successfully reset.')
                    : back()->withErrors(['email' => [__($status)]]);
    }

    public function manage(Request $request, $type = null)
    {
        $variables = array();

        if($type == 4)
        {
            $perSelected = $request->period;
            $periods = Period::latest('id')->get();
            $variables = array_merge($variables, ['perSelected', 'periods']);    
            
            $enrollment = Enrollment::where('period_id', isset($perSelected)? $perSelected : $periods->first())
                                    -> latest('id')
                                    -> get();

            $students = array(); 

            if(!$enrollment->isEmpty())
            {
                foreach($enrollment as $det)
                    $students = array_merge($students, [$det->user_id]);
                
                $user = User::whereIn('id', $students)
                        -> latest('id')
                        -> get();
            }
            else
            {
                $user = User::where('id', 42069)
                        -> latest('id')
                        -> get();
            }
        }
        else if($type != 5)
        {
            $user = User::where(function ($query) use ($type)
                    {
                        if($type != 0)
                            $query->where('type', $type);
                    })
                    -> latest('id')
                    -> get();
        }
        else
        {
            $user = Department::with('faculties')->latest('id')
                        -> get();
        }

        $variables = array_merge($variables, ['user', 'type']);

        return view('user.manage', compact($variables));
    }

    public function assignDean(Department $department)
    {
        $faculty = Faculty::where('department_id', $department->id)
                        -> latest('id')
                        -> get();

        return view('dean.assign', compact('faculty', 'department'));
    }

    public function assignDeanProcess(Request $request)
    {
        DB::table('faculties')
            -> where('department_id', $request->department_id)
            -> update(['isDean' => false]);

        if(DB::table('faculties')
            -> where('id', $request->user_id)
            -> update([
            'isDean' => true,
            'isAssDean' => false
        ]) == 0)
            return back()->with('message', 'Error in assigning dean. Please try again.');

        return redirect(route('user.manage', 5))->with('message', 'New College Dean assigned.');            
    }

    public function assignAssociate(Department $department)
    {
       $faculty = Faculty::where('department_id', $department->id)
                        -> latest('id')
                        -> get();

        return view('dean.assignAssociate', compact('faculty', 'department'));
    }

    public function assignAssociateProcess(Request $request)
    {
        DB::table('faculties')
            -> where('department_id', $request->department_id)
            -> update(['isAssDean' => false]);
        
        if(DB::table('faculties')
            -> where('id', $request->user_id)
            -> update(['isAssDean' => true, 
                       'isDean' => false
        ]) == 0)
            return back()->with('message', 'Error in assigning associate dean. Please try again.');

        return redirect(route('user.manage', 5))->with('message', 'New College Associate Dean assigned.');
    }

    public function assignChairman(Course $course)
    {
        $faculty = Faculty::where('department_id', $course->department_id)
                        -> latest('id')
                        -> get();

        return view('dean.assignChairman', compact('faculty', 'course'));
    }

    public function assignChairmanProcess(Course $course, Request $request)
    {
        if(!$course->update([
            'chairman' => $request->user_id
        ]))
            return back()->with('message', 'Error in assigning program chairman. Please try again.');

        return redirect(route('course.manage'))->with('message', 'New Program Chairman assigned.');
    }
}