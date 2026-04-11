@php
    $variant = $variant ?? 'user';
    $items = $items ?? [];
    $ariaLabel = $ariaLabel ?? '画面ヘッダー';
@endphp

<header class="portal-header portal-header--{{ $variant }}">
    <nav class="portal-header__nav" aria-label="{{ $ariaLabel }}">
        @foreach ($items as $item)
            @php
                $isActive = $item['active'] ?? false;
                $isDisabled = $item['disabled'] ?? false;
                $href = $item['href'] ?? null;
                $tag = $href && ! $isDisabled ? 'a' : 'span';
            @endphp

            <{{ $tag }}
                @if ($tag === 'a')
                    href="{{ $href }}"
                @endif
                class="portal-header__chip {{ $isActive ? 'is-active' : '' }} {{ $isDisabled ? 'is-disabled' : '' }}"
            >
                {{ $item['label'] }}
            </{{ $tag }}>
        @endforeach
    </nav>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="portal-header__logout">ログアウト</button>
    </form>
</header>
