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
<div class="container position-relative min-vh-100 d-flex justify-content-center align-items-center">
    <div class="w-100" style="max-width: 500px;">
    <!-- 右上リンク -->
<div class="d-flex justify-content-between align-items-start mb-4" style="max-width: 500px; margin: 0 auto;">
    <h1 class="m-5 text-center mb-5 text-nowrap" style="font-size: 2.5rem; ">管理画面ログイン</h1>
    <a href="{{ route('admin.show.register') }}"
       class="text-secondary text-decoration-none fw-bold ms-3 mt-n1 text-nowrap">
        新規会員登録はこちら
    </a>
</div>
        <form id="login-form" method="POST" action="{{ route('admin.login') }}">
    @csrf

    <!-- メールアドレス -->
    <div class="mb-3 row">
        <label for="email" class="col-md-4 col-form-label text-md-end">メールアドレス</label>
        <div class="col-md-8">
            <input id="email" type="email" class="form-control rounded-0" name="email" value="{{ old('email') }}"  autofocus>
            <div id="email-error" class="text-danger small"></div>
        </div>
    </div>

    <!-- パスワード -->
    <div class="mb-3 row">
        <label for="password" class="col-md-4 col-form-label text-md-end">パスワード</label>
        <div class="col-md-8">
            <input id="password" type="password" class="form-control rounded-0" name="password">
            <div id="password-error" class="text-danger small"></div>
        </div>
    </div>

    <!-- ログインボタン -->
    <div class="row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-secondary btn-lg rounded-0">ログイン</button>
        </div>
    </div>
</form>

<script>
document.getElementById('login-form').addEventListener('submit', function(e){
    e.preventDefault();

    // エラー初期化
    document.querySelectorAll('.text-danger').forEach(el => el.textContent = '');

    fetch("{{ route('admin.login.validate') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(Object.fromEntries(new FormData(this)))
    })
    .then(res => res.json())
    .then(data => {
        if(data.errors){
            for(const field in data.errors){
                const errorDiv = document.getElementById(field + '-error');
                if(errorDiv){
                    errorDiv.textContent = data.errors[field][0];
                }
            }
        } else if(data.success){
    // 管理者なら /admin/top に飛ばす
    window.location.href = "{{ route('admin.show.top') }}";
}
    });
});
</script>
    </div>
</div>
</body>
</html>