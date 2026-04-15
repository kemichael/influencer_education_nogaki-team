@extends('user.layouts.app')

@section('page_content')
@php
    $items = [
        ['label' => '時間割', 'disabled' => true],
        ['label' => '授業進捗', 'href' => route('show.progress')],
        ['label' => 'プロフィール設定', 'href' => route('show.profile'), 'active' => true],
    ];
    $profileImageUrl = null;
    if (! empty($user->profile_image)) {
        $profileImageUrl = \Illuminate\Support\Str::startsWith($user->profile_image, ['http://', 'https://', '/'])
            ? $user->profile_image
            : asset('storage/' . ltrim($user->profile_image, '/'));
    }
@endphp

<div class="portal-page">
    <div class="portal-shell">
        @include('partials.portal-header', ['variant' => 'user', 'items' => $items, 'ariaLabel' => 'ユーザー画面メニュー'])
        <div class="portal-stage">
            <div class="portal-back"><a href="{{ route('show.top') }}">← 戻る</a></div>
            <section class="portal-panel">
                <h1 class="portal-heading">プロフィール変更</h1>
                @if (session('status'))
                    <div class="portal-alert portal-alert--success">{{ session('status') }}</div>
                @endif
                <div class="profile-layout">
                    <div class="profile-avatar-panel">
                        <div class="profile-avatar">
                            @if ($profileImageUrl)
                                <img src="{{ $profileImageUrl }}" alt="{{ $user->name }}のプロフィール画像">
                            @else
                                <span>{{ mb_substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="profile-avatar-panel__meta">
                            <p class="profile-avatar-panel__label">プロフィール画像</p>
                            <p class="profile-avatar-panel__hint">jpeg / png</p>
                        </div>
                    </div>

                    <a href="{{ route('show.password.edit') }}" class="profile-switch" aria-label="パスワード変更画面へ">›</a>

                    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" class="profile-form">
                        @csrf
                        @method('PATCH')

                        <div class="portal-form-row">
                            <label for="profile_image">ファイル選択</label>
                            <input id="profile_image" name="profile_image" type="file" class="portal-input @error('profile_image') is-invalid @enderror">
                            @error('profile_image')<div class="portal-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="portal-form-row">
                            <label for="name">ユーザーネーム</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="portal-input @error('name') is-invalid @enderror">
                            @error('name')<div class="portal-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="portal-form-row">
                            <label for="name_kana">カナ</label>
                            <input id="name_kana" name="name_kana" type="text" value="{{ old('name_kana', $user->name_kana) }}" class="portal-input @error('name_kana') is-invalid @enderror">
                            @error('name_kana')<div class="portal-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="portal-form-row">
                            <label for="email">メールアドレス</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="portal-input @error('email') is-invalid @enderror">
                            @error('email')<div class="portal-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="portal-form-row">
                            <label for="grade_id">学年</label>
                            <select id="grade_id" name="grade_id" class="portal-input @error('grade_id') is-invalid @enderror">
                                <option value="">未設定</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" @selected(old('grade_id', $user->grade_id) == $class->id)>{{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('grade_id')<div class="portal-error">{{ $message }}</div>@enderror
                        </div>

                        <div class="portal-form-row">
                            <label>パスワード</label>
                            <a href="{{ route('show.password.edit') }}" class="portal-secondary-button">パスワードを変更する</a>
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
