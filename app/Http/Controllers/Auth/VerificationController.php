<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    use VerifiesEmails, RedirectsUsers;

    protected $redirectTo = '/home';
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Verified' => [
            'App\Listeners\LogVerifiedUser',
        ],
    ]; 

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('auth.verify-email', [
                            'pageTitle' => __('Account Verification')
                        ]);
    }

    public function handler(EmailVerificationRequest $request)
    {
        $request->fulfill();
 
        return redirect('/home');
    }

    public function resend(Request $request) 
    {
        $request->user()->sendEmailVerificationNotification();
     
        return back()->with('message', 'Verification link sent!');
    }
}
