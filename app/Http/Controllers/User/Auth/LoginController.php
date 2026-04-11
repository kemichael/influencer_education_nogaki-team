<?php

namespace App\Http\Controllers\User\Auth;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{
    protected $redirectTo = '/user/top';

    public function showLoginForm()
    {
        return view('user.auth.login');
    }
}
