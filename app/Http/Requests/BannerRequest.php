<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // 管理者認証済みなので true
    }

    public function rules(): array
    {
        return [
            'banners'   => ['required', 'array', 'max:5'], // 複数ファイル、最大5枚まで
            'banners.*' => ['file', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'], 
            // 1ファイル2MBまで
        ];
    }

    public function messages(): array
    {
        return [
            'banners.required'   => 'バナー画像を選択してください。',
            'banners.array'      => 'バナーは複数ファイルとして送信してください。',
            'banners.max'        => 'アップロードできるのは最大5枚までです。',
            'banners.*.image'    => 'アップロードできるのは画像ファイルのみです。',
            'banners.*.mimes'    => '画像形式は jpeg, png, jpg, gif, webp のみ対応しています。',
            'banners.*.max'      => '1つのファイルサイズは2MB以下にしてください。',
        ];
    }
}
