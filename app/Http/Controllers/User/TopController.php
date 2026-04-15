<?php

namespace App\Http\Controllers\User;

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
        $articles = Article::query()
            ->orderByDesc('posted_date')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('user.top', compact('articles'));
    }
}
