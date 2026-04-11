<?php

namespace App\Http\Controllers\Admin\Auth;

class RegisterController extends \App\Http\Controllers\Auth\RegisterController
{
    protected $redirectTo = '/admin/top';

    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }

    public function showRegistrationForm()
    {
        return $this->showRegisterForm();
    }
}
