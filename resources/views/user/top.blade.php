@extends('user.layouts.app')

@section('page_content')
@php
    $items = [
        ['label' => '時間割', 'disabled' => true],
        ['label' => '授業進捗', 'href' => route('show.progress')],
        ['label' => 'プロフィール設定', 'href' => route('show.profile')],
    ];
@endphp

<div class="portal-page">
    <div class="portal-shell">
        @include('partials.portal-header', ['variant' => 'user', 'items' => $items, 'ariaLabel' => 'ユーザー画面メニュー'])

        <div class="portal-stage">
            <section class="portal-panel">
                <div class="portal-section-head">
                    <h1 class="portal-heading">トップページ</h1>
                </div>

                <div class="progress-summary mb-4">
                    @php $latestArticle = $articles->first(); @endphp
                    <a class="progress-summary__item text-decoration-none text-reset" href="{{ $latestArticle ? route('show.article', ['id' => $latestArticle->id]) : route('show.progress') }}">
                        <strong>{{ $articles->count() }}</strong>
                        <span>最新お知らせ</span>
                    </a>
                    <a class="progress-summary__item text-decoration-none text-reset" href="{{ route('show.progress') }}">
                        <strong>進む</strong>
                        <span>授業進捗へ</span>
                    </a>
                </div>

                <div class="article-table-wrap">
                    <table class="article-table">
                        <thead>
                            <tr>
                                <th>投稿日時</th>
                                <th>タイトル</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($articles as $article)
                                <tr>
                                    <td>{{ optional($article->posted_date)->format('Y年n月j日') }}</td>
                                    <td><a href="{{ route('show.article', ['id' => $article->id]) }}">{{ $article->title }}</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">お知らせはまだありません。</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
