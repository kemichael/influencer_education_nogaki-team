@extends('user.layouts.app')

@section('content')
    <div class="userTop">
        <div class="banner-container" id="banner">
            @foreach ($banners as $i => $b)
                <div class="banner-slide {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}">
                    <img src="{{ $b->image }}" alt="">
                </div>
            @endforeach
            <div class="dots">
                @foreach ($banners as $i => $b)
                    <button class="dot {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}"
                        type="button"></button>
                @endforeach
            </div>
        </div>

        <div class="infomation">
            <h2>お知らせ</h2>

            <dl class="info">
                @foreach ($articles as $article)
                    <dt>{{ $article->posted_date }}</dt>
                    <dd><a href="#">{{ $article->title }}</a></dd>
                @endforeach
            </dl>
        </div>
    </div>
    <script>
        (function() {
            const container = document.getElementById('banner');
            if (!container) return;

            const slides = Array.from(container.querySelectorAll('.banner-slide'));
            const dots = Array.from(container.querySelectorAll('.dot'));
            let current = 0;

            function goTo(index) {
                slides[current].classList.remove('is-active');
                dots[current].classList.remove('is-active');

                current = index;

                slides[current].classList.add('is-active');
                dots[current].classList.add('is-active');
            }

            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    goTo(parseInt(dot.dataset.index, 10));
                });
            });
        })();
    </script>
@endsection