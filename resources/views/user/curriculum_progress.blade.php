@extends('user.layouts.app')

@section('body_class', 'progress-page-body')
@section('main_class', 'progress-page-main')

@section('page_content')
@php
    $palette = ['progress-card--coral', 'progress-card--sky', 'progress-card--mint', 'progress-card--butter', 'progress-card--leaf', 'progress-card--peach'];
    $profileImageUrl = null;
    if (! empty($user->profile_image)) {
        $profileImageUrl = \Illuminate\Support\Str::startsWith($user->profile_image, ['http://', 'https://', '/'])
            ? $user->profile_image
            : asset('storage/' . ltrim($user->profile_image, '/'));
    }
    $totalCurriculums = $classes->sum(fn ($class) => $class->curriculums->count());
    $completedCount = count($clearCurriculumIds);
    $placeholderCards = ['授業枠 A', '授業枠 B', '授業枠 C', '授業枠 D', '授業枠 E', '授業枠 F'];
    $items = [
        ['label' => '時間割', 'disabled' => true],
        ['label' => '授業進捗', 'href' => route('show.progress'), 'active' => true],
        ['label' => 'プロフィール設定', 'href' => route('show.profile')],
    ];
@endphp

<div class="progress-page">
    <div class="portal-shell">
        @include('partials.portal-header', ['variant' => 'user', 'items' => $items, 'ariaLabel' => 'ユーザー画面メニュー'])
        <div class="portal-stage">
            <div class="portal-back"><a href="{{ route('show.top') }}">← 戻る</a></div>

            <section class="progress-hero">
                <div class="progress-avatar" aria-hidden="true">
                    @if ($profileImageUrl)
                        <img src="{{ $profileImageUrl }}" alt="{{ $user->name }}のプロフィール画像">
                    @else
                        <span>{{ mb_substr($user->name, 0, 1) }}</span>
                    @endif
                </div>

                <div class="progress-hero__content">
                    <h1>{{ $user->name }}さんの授業進捗</h1>
                    <div class="progress-hero__meta">
                        <p>現在の学年</p>
                        <span class="progress-grade-badge">{{ optional($user->schoolClass)->name ?? '学年未設定' }}</span>
                    </div>
                    <div class="progress-summary">
                        <div class="progress-summary__item"><strong>{{ $completedCount }}</strong><span>受講済み</span></div>
                        <div class="progress-summary__item"><strong>{{ $totalCurriculums }}</strong><span>登録授業数</span></div>
                    </div>
                </div>
            </section>

            @if ($classes->isEmpty())
                <div class="progress-empty-note">学年データがまだ未登録のため、下のカードはレイアウトサンプルです。授業データを登録するとこのエリアに一覧表示されます。</div>
                <div class="progress-grid">
                    @foreach ($placeholderCards as $label)
                        <article class="progress-card {{ $palette[$loop->index % count($palette)] }}">
                            <div class="progress-card__pill">{{ $label }}</div>
                            <ul class="progress-card__list progress-card__list--placeholder">
                                @for ($i = 0; $i < 5; $i++)
                                    <li class="progress-card__skeleton"></li>
                                @endfor
                            </ul>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="progress-grid">
                    @foreach ($classes as $class)
                        @php
                            $theme = $palette[$loop->index % count($palette)];
                            $completedInClass = $class->curriculums->whereIn('id', $clearCurriculumIds)->count();
                            $totalInClass = $class->curriculums->count();
                        @endphp
                        <article class="progress-card {{ $theme }}">
                            <div class="progress-card__header">
                                <span class="progress-card__pill">{{ $class->name }}</span>
                                <span class="progress-card__count">{{ $completedInClass }} / {{ $totalInClass }}</span>
                            </div>
                            @if ($class->curriculums->isEmpty())
                                <p class="progress-card__empty">授業データはまだ登録されていません。</p>
                            @else
                                <ul class="progress-card__list">
                                    @foreach ($class->curriculums as $curriculum)
                                        @php $isCompleted = in_array($curriculum->id, $clearCurriculumIds, true); @endphp
                                        <li class="progress-card__item">
                                            <span class="progress-card__title">{{ $curriculum->title }}</span>
                                            <span class="progress-card__status {{ $isCompleted ? 'is-complete' : 'is-pending' }}">{{ $isCompleted ? '受講済み' : '未受講' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
