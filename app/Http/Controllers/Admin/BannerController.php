<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showBannerEdit()
    {
        return view('admin.banner_edit');
    }
}
