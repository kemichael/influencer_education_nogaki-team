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
            <div class="portal-back"><a href="{{ route('admin.show.top') }}">← 戻る</a></div>
            <section class="portal-panel">
                <h1 class="portal-heading">配信設定ページ</h1>
                <div class="portal-empty-state">配信設定ID: {{ $id }} を受け取っています。仕様書どおりのファイル名に揃えています。</div>
            </section>
        </div>
    </div>
</div>
@endsection
