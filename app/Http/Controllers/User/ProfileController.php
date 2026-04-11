<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Request $request)
    {
        return $this->showProfileForm($request);
    }

    public function showProfileForm(Request $request)
    {
        $user = $request->user()->load('schoolClass');
        $classes = SchoolClass::query()->academicOrder()->get();

        return view('user.profile_edit', compact('user', 'classes'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'name_kana' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'grade_id' => ['nullable', 'exists:classes,id'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ], [
            'profile_image.mimes' => 'プロフィール画像は jpeg または png を選択してください。',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && ! str_starts_with($user->profile_image, 'http')) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $validated['profile_image'] = $request->file('profile_image')->store('profile-images', 'public');
        }

        $user->update($validated);

        return redirect()
            ->route('show.profile')
            ->with('status', 'プロフィールを更新しました。');
    }

    public function editPassword(Request $request)
    {
        return $this->showPasswordForm($request);
    }

    public function showPasswordForm(Request $request)
    {
        return view('user.password_edit', ['user' => $request->user()]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
        ], [
            'password.min' => '8文字以上で入力してください。',
            'password.max' => '16文字以内で入力してください。',
            'password.confirmed' => '確認用パスワードが一致しません。',
        ]);

        if (! Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => '現在のパスワードが一致しません。'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('show.password.edit')
            ->with('status', 'パスワードを変更しました。');
    }
}
