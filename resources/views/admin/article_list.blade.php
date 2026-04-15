@extends('admin.layouts.app')

@section('page_content')
@php
    $items = [
        ['label' => '授業管理', 'href' => route('admin.show.curriculum.list')],
        ['label' => 'お知らせ管理', 'href' => route('admin.show.article.list'), 'active' => true],
        ['label' => 'バナー管理', 'href' => route('admin.show.banner.edit')],
    ];
@endphp

<div class="portal-page">
    <div class="portal-shell">
        @include('partials.portal-header', ['variant' => 'admin', 'items' => $items, 'ariaLabel' => '管理画面メニュー'])
        <div class="portal-stage">
            <div class="portal-back"><a href="{{ route('admin.show.top') }}">← 戻る</a></div>
            <section class="portal-panel">
                <div class="portal-section-head">
                    <h1 class="portal-heading">お知らせ一覧</h1>
                    <a href="{{ route('admin.show.article.create') }}" class="portal-primary-button">新規登録</a>
                </div>
                @if (session('status'))
                    <div class="portal-alert portal-alert--success">{{ session('status') }}</div>
                @endif
                @if ($articles->isEmpty())
                    <div class="portal-empty-state">お知らせはまだ登録されていません。</div>
                @else
                    <div class="article-table-wrap">
                        <table class="article-table">
                            <thead>
                                <tr>
                                    <th>投稿日時</th>
                                    <th>タイトル</th>
                                    <th class="text-end">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articles as $article)
                                    <tr>
                                        <td>{{ optional($article->posted_date)->format('Y年n月j日') }}</td>
                                        <td>{{ $article->title }}</td>
                                        <td>
                                            <div class="table-actions">
                                                <a href="{{ route('admin.show.article.edit', ['id' => $article->id]) }}" class="portal-action-button portal-action-button--edit">変更する</a>
                                                <form method="POST" action="{{ route('admin.article.delete', ['id' => $article->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="portal-action-button portal-action-button--delete" onclick="return confirm('このお知らせを削除しますか？')">削除</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="portal-pagination">{{ $articles->links() }}</div>
                @endif
            </section>
        </div>
    </div>
</div>
@endsection
