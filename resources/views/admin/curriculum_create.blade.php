@extends('admin.layouts.app')

@section('page_content')
@php
    $items = [
        ['label' => '授業管理', 'href' => route('admin.show.curriculum.list'), 'active' => true],
        ['label' => 'お知らせ管理', 'href' => route('admin.show.article.list')],
        ['label' => 'バナー管理', 'href' => route('admin.show.banner.edit')],
    ];
@endphp

<div class="portal-page">
    <div class="portal-shell">
        @include('partials.portal-header', ['variant' => 'admin', 'items' => $items, 'ariaLabel' => '管理画面メニュー'])
        <div class="portal-stage">
            <div class="portal-back"><a href="{{ route('admin.show.curriculum.list') }}">← 戻る</a></div>
            <section class="portal-panel portal-panel--form">
                <h1 class="portal-heading">授業新規登録ページ</h1>
                <div class="portal-empty-state">仕様書名に合わせたファイルを作成済みです。授業登録フォーム本体はこれから実装します。</div>
            </section>
        </div>
    </div>
</div>
@endsection
