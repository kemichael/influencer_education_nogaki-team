<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(int $id)
    {
        return $this->showArticle($id);
    }

    public function showArticle(int $id)
    {
        $article = Article::query()->findOrFail($id);

        return view('user.article', compact('article'));
    }
}
