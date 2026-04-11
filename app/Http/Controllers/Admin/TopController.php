<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;

class TopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showTop()
    {
        $articleCount = Article::count();

        return view('admin.top', compact('articleCount'));
    }
}
