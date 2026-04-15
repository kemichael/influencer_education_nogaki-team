<?php

namespace App\Http\Controllers\Admin\Auth;

class LoginController extends \App\Http\Controllers\Auth\LoginController
{
    protected $redirectTo = '/admin/top';

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }
}
