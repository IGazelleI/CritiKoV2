<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Charts\FacultyChart;
use Illuminate\Http\Request;
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
        $request['password'] = Hash::make($request->password);
        $user = User::create($request->all());

        if(!$user)
            return back()->with('message', 'Error in creating user. Try again later.');
        else
        {
            while(!User::createByRole($request->all(), $user->id)){}
        }

        return back()->with('message', 'Account added.');
    }
    //DILI PA MUGAWAS ANG DEAN KAY NABUANG SIYA 
    public function auth(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ],[
            'email.required' => 'Required',
            'password.required' => 'Required'
        ]);

        if(auth()->attempt($formFields, $request->remember))
        {
            $request->session()->regenerate();

            return redirect(route('home'))->with('message', 'You are now logged in.');
        }
        else
            return back()->withErrors(['email' => 'Invalid login attempt.'])->onlyInput('email');
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

    public function manage($type = null)
    {
        if($type != 5)
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

        return view('user.manage', compact('user', 'type'));
    }

    public function assignDean(Department $department)
    {
        $faculty = Faculty::where('department_id', $department)
                        -> latest('id')
                        -> get();

        return view('dean.assign', compact('faculty', 'department'));
    }

    public function assignDeanProcess(Request $request)
    {
        DB::table('faculties')
            -> where('department_id', $request->department_id)
            -> update(['isDean' => false]);

        $faculty = Faculty::find($request->user_id);
        
        if(!$faculty->update([
            'isDean' => true
        ]))
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
        
        if(!DB::table('faculties')
            -> where('department_id', $request->department_id)
            -> where('id', $request->user_id)
            -> update(['isAssDean' => true])
        )
            return back()->with('message', 'Error in assigning associate dean. Please try again.');

        return redirect(route('user.manage', 5))->with('message', 'New College Associate Dean assigned.');
    }

    public function assignChairman(Department $department)
    {
        $faculty = Faculty::where('department_id', $department->id)
                        -> latest('id')
                        -> get();

        return view('dean.assignChairman', compact('faculty', 'department'));
    }

    public function assignChairmanProcess(Request $request)
    {
        DB::table('faculties')
            -> where('department_id', $request->department_id)
            -> update(['isChairman' => false]);

        if(!DB::table('faculties')
            -> where('department_id', $request->department_id)
            -> where('id', $request->user_id)
            -> update(['isChairman' => true])
        )
            return back()->with('message', 'Error in assigning college chairman. Please try again.');

        return redirect(route('user.manage', 5))->with('message', 'New College Chairman assigned.');
    }

    
    public function s()
    {
        //overall chart
        $overAllChart = new FacultyChart();

        $overAllChart-> labels(['One', 'Two', 'Three', 'Four'])
            -> dataset('Chart Name', 'line', [50, 20, 70, 15]);

        //evaluation progress chart
        $evalProgress = new FacultyChart();

        $evalProgress-> labels(['Pending', 'Finished'])
            -> dataset('Progess', 'doughnut', [75, 25])
            -> backgroundColor(['Yellow', 'Green'])
            -> options(['responsive' => true]);
        
        return view('admin.s', compact('overAllChart', 'evalProgress'));
    }
}