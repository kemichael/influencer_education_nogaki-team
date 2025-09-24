<?php

namespace App\Http\Controllers\admin;   // 名前空間は Admin に統一

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Admin;                   // Admin モデルを利用
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * 登録後のリダイレクト先
     *
     * @var string
     */
    protected $redirectTo = '/admin/top';

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->middleware('guest:admin'); // adminガードで未ログイン時のみアクセス可能
    }

    /**
     * Adminガードを利用
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * バリデーションルール
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required','max:255', 'regex:/^[^\x01-\x7E\xA1-\xDF]+$/u'], // 全角
            'kana' => ['required', 'string', 'max:255', 'regex:/^[ァ-ンヴー]+$/u'], // 全角カタカナ
            'email' => ['required','email', 'min:8', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed', 'regex:/^[a-zA-Z0-9]+$/'], // 半角英数字
        ], [
            // name
            'name.required' => 'ユーザーネームを入力してください。',
            'name.max' => 'ユーザーネームは255文字以内で入力してください。',
            'name.regex'=> 'ユーザーネームは全角で入力してください。',

            // kana
            'kana.required' => 'ユーザーネームをカタカナで入力してください。',
            'kana.string' => 'カタカナで入力してください。',
            'kana.max' => '255文字以内で入力してください。',
            'kana.regex'=> '全角カタカナで入力してください。',

            // email
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '＠を含むアドレス形式で入力してください。',
            'email.min' => 'メールアドレスは8文字以上で入力してください。',
            'email.unique' => 'このメールアドレスはすでに登録されています。',

            // password
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは16文字以内で入力してください。',
            'password.regex'=> '半角英数字で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
        ]);
    }

    /**
     * 登録処理
     */
    protected function create(array $data)
    {
        return Admin::create([
            'name' => $data['name'],
            'kana' => $data['kana'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * 登録フォームを表示
     */
    public function showRegisterForm()
    {
        return view('admin.auth.register');
    }
    public function validateRegister(\Illuminate\Http\Request $request)
{
    $validator = $this->validator($request->all());

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()]);
    }

    return response()->json(['success' => true]);
}
}
