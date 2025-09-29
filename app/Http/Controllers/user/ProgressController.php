<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ProgressController extends Controller
{
    public function showProgress()
    {
        return view('user.curriculum_progress'); 
    }
}