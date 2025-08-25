<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/top';
    public function showLoginForm() {
        return view('/auth/login');
    }

    /**
     * ログアウト後の遷移先を変更
     */
    public function logout(Request $request)
    {
        // Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 遷移先を好きなURL/ルートに変更
        return redirect('/login');          // 例: 固定URL
        // return redirect()->route('goodbye');     // 例: ルート名
        // return redirect('/');                    // 例: トップへ
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
