<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;        //追記

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    protected function broker()                 //追記
    {                                           //追記
        return Password::broker('admins');      //追記
    }                                           //追記
}  