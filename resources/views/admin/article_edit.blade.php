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
            <div class="portal-back"><a href="{{ route('admin.show.article.list') }}">← 戻る</a></div>
            <section class="portal-panel portal-panel--form">
                <h1 class="portal-heading">お知らせ編集</h1>
                <form method="POST" action="{{ route('admin.article.edit.submit', ['id' => $article->id]) }}" class="admin-form">
                    @include('admin.articles._form', ['method' => 'PUT'])
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
