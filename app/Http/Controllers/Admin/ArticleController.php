<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return $this->showArticleList();
    }

    public function showArticleList()
    {
        $articles = Article::query()
            ->orderByDesc('posted_date')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.article_list', compact('articles'));
    }

    public function create()
    {
        return $this->showArticleCreate();
    }

    public function showArticleCreate()
    {
        $article = new Article([
            'posted_date' => now()->toDateString(),
        ]);

        return view('admin.article_create', compact('article'));
    }

    public function store(Request $request)
    {
        Article::create($this->validateArticle($request));

        return redirect()
            ->route('admin.show.article.list')
            ->with('status', 'お知らせを登録しました。');
    }

    public function edit(int $id)
    {
        return $this->showArticleEdit($id);
    }

    public function showArticleEdit(int $id)
    {
        $article = Article::query()->findOrFail($id);

        return view('admin.article_edit', compact('article'));
    }

    public function update(Request $request, int $id)
    {
        $article = Article::query()->findOrFail($id);
        $article->update($this->validateArticle($request));

        return redirect()
            ->route('admin.show.article.list')
            ->with('status', 'お知らせを更新しました。');
    }

    public function destroy(int $id)
    {
        $article = Article::query()->findOrFail($id);
        $article->delete();

        return redirect()
            ->route('admin.show.article.list')
            ->with('status', 'お知らせを削除しました。');
    }

    private function validateArticle(Request $request): array
    {
        return $request->validate([
            'posted_date' => ['required', 'date'],
            'title' => ['required', 'string', 'max:255'],
            'article_contents' => ['nullable', 'string'],
        ], [
            'posted_date.required' => '投稿日時を入力してください。',
            'title.required' => 'タイトルを入力してください。',
        ]);
    }
}
