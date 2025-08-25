<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    {{-- <link href="resourse/css/app.css"rel="stylesheet"> --}}

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    @if (!Request::is('login') && !Request::is('register'))
        <div id="app">
            {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"> --}}
            <div class="containerH">
                <div class="userNav">
                    <ul>
                        <li><a href="../curriculum_list">時間割</a></li>
                        <li><a href="../curriculum_progress">授業進捗</a></li>
                        <li><a href="#">プロフィール設定</a></li>
                    </ul>
                </div>
                <div class="logout_right">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            {{ __('ログアウト') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
            </div>
            {{-- </nav> --}}
            <main class="py-4">
                @yield('content')
            </main>
        @else
            <main class="py-4">
                @yield('content')
            </main>
    @endif
    </div>
</body>

</html>
