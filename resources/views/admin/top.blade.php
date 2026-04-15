@extends('admin.layouts.app')

@section('page_content')
@php
    $items = [
        ['label' => '授業管理', 'href' => route('admin.show.curriculum.list')],
        ['label' => 'お知らせ管理', 'href' => route('admin.show.article.list')],
        ['label' => 'バナー管理', 'href' => route('admin.show.banner.edit')],
    ];
@endphp

<div class="portal-page">
    <div class="portal-shell">
        @include('partials.portal-header', ['variant' => 'admin', 'items' => $items, 'ariaLabel' => '管理画面メニュー'])
        <div class="portal-stage">
            <section class="portal-panel">
                <h1 class="portal-heading">トップページ</h1>
                <div class="progress-summary">
                    <a href="{{ route('admin.show.article.list') }}" class="progress-summary__item text-decoration-none text-reset">
                        <strong>{{ $articleCount }}</strong>
                        <span>お知らせ管理</span>
                    </a>
                    <a href="{{ route('admin.show.curriculum.list') }}" class="progress-summary__item text-decoration-none text-reset">
                        <strong>授業</strong>
                        <span>授業一覧へ</span>
                    </a>
                    <a href="{{ route('admin.show.banner.edit') }}" class="progress-summary__item text-decoration-none text-reset">
                        <strong>バナー</strong>
                        <span>設定画面へ</span>
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
