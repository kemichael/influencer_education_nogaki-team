@extends('layouts.app')

@section('hide_default_nav', '1')
@section('body_class', 'portal-page-body')
@section('main_class', 'portal-page-main')

@section('content')
@php
    $adminHeaderItems = [
        ['label' => '授業管理', 'disabled' => true],
        ['label' => 'お知らせ管理', 'href' => route('admin.show.article.list'), 'active' => true],
        ['label' => 'バナー管理', 'disabled' => true],
    ];
@endphp

<div class="portal-page">
    <div class="portal-shell">
        @include('partials.portal-header', [
            'variant' => 'admin',
            'items' => $adminHeaderItems,
            'ariaLabel' => '管理画面メニュー',
        ])

        <div class="portal-stage">
            <div class="portal-back">
                <a href="{{ route('admin.show.article.list') }}">← 戻る</a>
            </div>

            <section class="portal-panel portal-panel--form">
                <h1 class="portal-heading">お知らせ新規登録</h1>

                <form method="POST" action="{{ route('admin.article.create.submit') }}" class="admin-form">
                    @include('admin.articles._form', ['method' => 'POST'])
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
