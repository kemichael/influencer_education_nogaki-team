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

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-white">
<style>
.navbar-custom {
    background-color: #ff5900ff; /* オレンジ */
}
.navbar-custom {
    background-color: #ff5900ff;
    margin-bottom: 0.5rem; /* 好きな高さに調整 */
}
</style>

<!-- ナビバー（下マージン付き） -->
<nav class="navbar navbar-expand-xxl navbar-light navbar-custom shadow-sm ">
    <div class="container-fluid d-flex py-4">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- 左側メニュー -->
            <ul class="navbar-nav me-auto d-flex gap-5 ms-5">
                <li class="nav-item">
    <a class="btn fs-2 py-1 rounded-4"
       style="width: 120%; background-color: cyan; color: white;"
       href="{{ route('user.show.curriculum') }}">
       時間割
    </a>
</li>
<li class="nav-item">
<a class="btn fs-2 py-1 rounded-4"
   style="width: 120%; background-color: cyan; color: white;"
   href="{{ route('user.show.progress') }}">
   授業進捗
</a>
</li>
<li class="nav-item">
    <a class="btn fs-2 py-1 rounded-4"
       style="width: 120%; background-color: cyan; color: white;"
       href="{{ route('user.show.profile') }}">
       プロフィール設定
    </a>
</li>
            </ul>

            <!-- 右側ログアウト -->
            <ul class="navbar-nav ms-auto">
                <a href="#"
   class="text-black hover:text-gray-200 text-decoration-none fs-1"
   onclick="event.preventDefault(); document.getElementById('user-logout-form').submit();">
    ログアウト
</a>

<form id="user-logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
    @csrf
</form>
            </ul>
        </div>
    </div>
</nav>
        <main class="py-2">
            @yield('content')
        </main>
    </div>
</body>
</html>
