@extends('admin.layouts.app')

@section('page_content')
@php
    $items = [
        ['label' => '授業管理', 'href' => route('admin.show.curriculum.list')],
        ['label' => 'お知らせ管理', 'href' => route('admin.show.article.list')],
        ['label' => 'バナー管理', 'href' => route('admin.show.banner.edit'), 'active' => true],
    ];
@endphp

<div class="portal-page">
    <div class="portal-shell">
        @include('partials.portal-header', ['variant' => 'admin', 'items' => $items, 'ariaLabel' => '管理画面メニュー'])
        <div class="portal-stage">
            <div class="portal-back"><a href="{{ route('admin.show.top') }}">← 戻る</a></div>
            <section class="portal-panel">
                <h1 class="portal-heading">バナー設定ページ</h1>
                <div class="portal-empty-state">バナー設定画面のファイル名とルートを仕様書に合わせて作成しました。</div>
            </section>
        </div>
    </div>
</div>
@endsection
