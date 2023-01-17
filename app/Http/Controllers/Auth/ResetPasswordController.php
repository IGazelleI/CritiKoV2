<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function reset($token)
    {
        return view('user.reset-password', [
            'token' => $token
        ]);
    }
}
