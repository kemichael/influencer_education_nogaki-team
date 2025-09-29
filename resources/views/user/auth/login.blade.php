<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザーログイン（ダミー）</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-4">ユーザーログイン</h3>

        <form>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" class="form-control" id="email" placeholder="test@example.com">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" class="form-control" id="password" placeholder="********">
            </div>

            <button type="button" class="btn btn-primary w-100">ログイン</button>
        </form>

        <div class="text-center mt-3">
            <a href="#">パスワードを忘れた方はこちら</a>
        </div>
    </div>
</div>

</body>
</html>
