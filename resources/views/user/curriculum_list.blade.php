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
                <h1 class="portal-heading">授業一覧</h1>
                <div class="progress-grid">
                    @forelse ($classes as $class)
                        <article class="progress-card progress-card--sky">
                            <div class="progress-card__header">
                                <span class="progress-card__pill">{{ $class->name }}</span>
                            </div>
                            <ul class="progress-card__list">
                                @forelse ($class->curriculums as $curriculum)
                                    <li class="progress-card__item">
                                        <span class="progress-card__title">{{ $curriculum->title }}</span>
                                    </li>
                                @empty
                                    <li class="progress-card__item"><span class="progress-card__title">未登録</span></li>
                                @endforelse
                            </ul>
                        </article>
                    @empty
                        <div class="portal-empty-state">授業データがまだ登録されていません。</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
