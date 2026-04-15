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
            <div class="portal-back"><a href="{{ route('show.top') }}">← 戻る</a></div>
            <section class="portal-panel portal-panel--article">
                <p class="portal-article__date">{{ optional($article->posted_date)->format('Y年n月j日') }}</p>
                <h1 class="portal-article__title">{{ $article->title }}</h1>
                <div class="portal-article__body">{!! nl2br(e($article->article_contents ?: '本文はまだ登録されていません。')) !!}</div>
            </section>
        </div>
    </div>
</div>
@endsection
