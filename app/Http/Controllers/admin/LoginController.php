<?php

namespace App\Http\Controllers\admin; 

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; 
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
    protected $redirectTo =  '/admin/top';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout'); //修正
    }

 protected function guard()                              //追記
    {                                                       //追記
        return Auth::guard('admin');                        //追記
    }                                                       //追記


public function logout(Request $request)
{
    // 管理者ガードでログアウト
    Auth::guard('admin')->logout();

    // セッション破棄
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // 管理者ログインページにリダイレクト
    return redirect()->route('admin.show.login');
}



public function showLoginForm()
{
    return view('admin.auth.login');
}            
public function loginvalidate(Request $request)
{
    // 空欄や形式チェック
    $validator = \Validator::make($request->all(), [
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:8', 'max:16'],
    ], [
        'email.required' => 'メールアドレスを入力してください。',
        'email.email' => '＠を含むアドレス形式で入力してください。',
        'password.required' => 'パスワードを入力してください。',
        'password.min' => 'パスワードは8文字以上で入力してください。',
        'password.max' => 'パスワードは16文字以内で入力してください。',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // 認証チェック
    $credentials = $request->only('email', 'password');
    if (!Auth::guard('admin')->attempt($credentials)) {
        return response()->json([
            'errors' => [
                'email' => ['メールアドレス、またはパスワードを確認してください。'],
                'password' => ['メールアドレス、またはパスワードを確認してください。']
            ]
        ], 422);
    }

    // 認証成功
    $request->session()->regenerate();
    return response()->json(['success' => true]);
}


}
