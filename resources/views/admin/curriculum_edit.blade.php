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
                <h1 class="portal-heading">授業編集ページ</h1>
                <div class="portal-empty-state">授業ID: {{ $id }} を受け取っています。ここに編集フォームを実装できます。</div>
            </section>
        </div>
    </div>
</div>
@endsection
