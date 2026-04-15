<?php

namespace App\Http\Controllers\User\Auth;

class RegisterController extends \App\Http\Controllers\Auth\RegisterController
{
    protected $redirectTo = '/user/top';

    public function showRegisterForm()
    {
        return view('user.auth.register');
    }

    public function showRegistrationForm()
    {
        return $this->showRegisterForm();
    }
}
