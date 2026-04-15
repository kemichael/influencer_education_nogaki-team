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
            <section class="portal-panel">
                <h1 class="portal-heading">配信ページ</h1>
                <div class="portal-empty-state">配信ページの詳細実装はこれから追加します。対象ID: {{ $id ?? '未指定' }}</div>
            </section>
        </div>
    </div>
</div>
@endsection
