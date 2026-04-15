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
            <div class="portal-back"><a href="{{ route('admin.show.top') }}">← 戻る</a></div>
            <section class="portal-panel">
                <div class="portal-section-head">
                    <h1 class="portal-heading">授業一覧</h1>
                    <a href="{{ route('admin.show.curriculum.create') }}" class="portal-primary-button">新規登録</a>
                </div>
                <div class="portal-empty-state">授業管理画面はこれから詳細実装します。</div>
            </section>
        </div>
    </div>
</div>
@endsection
