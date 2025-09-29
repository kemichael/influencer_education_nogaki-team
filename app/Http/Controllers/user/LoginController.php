<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ログインフォーム（ダミーページ）
    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        Auth::guard('web')->logout(); // user guard が別なら 'user' に変更

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ダミーログインページへリダイレクト
        return redirect()->route('user.show.login');
    }
}
