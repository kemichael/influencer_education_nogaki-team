<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Article;

class TopController extends Controller
{
    public function showTop()
    {
        $banners = Banner::orderBy('display_order', 'asc')->get();
        $articles = Article::orderBy('posted_date', 'desc')->get();

        return view('user.top', compact('banners', 'articles'));
    }
}