@extends('user.layouts.app')

@section('page_content')
@php
    $items = [
        ['label' => '時間割', 'disabled' => true],
        ['label' => '授業進捗', 'href' => route('show.progress')],
        ['label' => 'プロフィール設定', 'href' => route('show.profile'), 'active' => true],
    ];
@endphp

<div class="portal-page">
    <div class="portal-shell">
        @include('partials.portal-header', ['variant' => 'user', 'items' => $items, 'ariaLabel' => 'ユーザー画面メニュー'])
        <div class="portal-stage">
            <div class="portal-back"><a href="{{ route('show.profile') }}">← 戻る</a></div>
            <section class="portal-panel portal-panel--narrow">
                <h1 class="portal-heading">パスワード設定</h1>
                @if (session('status'))
                    <div class="portal-alert portal-alert--success">{{ session('status') }}</div>
                @endif
                <div class="password-layout">
                    <a href="{{ route('show.profile') }}" class="profile-switch profile-switch--left" aria-label="プロフィール画面へ">‹</a>
                    <form method="POST" action="{{ route('user.password.update') }}" class="password-form">
                        @csrf
                        @method('PATCH')
                        <div class="portal-form-row">
                            <label for="current_password">旧パスワード</label>
                            <input id="current_password" name="current_password" type="password" class="portal-input @error('current_password') is-invalid @enderror">
                            @error('current_password')<div class="portal-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="portal-form-row">
                            <label for="password">新パスワード</label>
                            <input id="password" name="password" type="password" class="portal-input @error('password') is-invalid @enderror">
                            @error('password')<div class="portal-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="portal-form-row">
                            <label for="password_confirmation">新パスワード確認</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="portal-input">
                        </div>
                        <div class="portal-submit-wrap">
                            <button type="submit" class="portal-submit-button">登録</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
