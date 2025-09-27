<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Banner;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // バナー管理ページ表示
    public function showBannerEdit()
    {
        $banners = Banner::all();
        return view('admin.banner_edit', compact('banners'));
    }

    // バナー登録
    public function register(Request $request)
    {
        try {
            // バリデーション
            $request->validate([
                'banners'   => 'required|array',
                'banners.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'banners.required' => 'ファイルを選択してください。',
                'banners.*.image'  => '画像ファイルを選択してください。',
                'banners.*.mimes'  => '対応形式は jpeg, png, jpg, gif です。',
                'banners.*.max'    => '画像サイズは2MB以下にしてください。',
            ]);

            $savedBanners = [];
            $storedFiles = []; // 失敗時に削除するファイルを記録

            DB::beginTransaction(); // 🔹 トランザクション開始

            foreach ($request->file('banners') as $file) {
                if (!$file->isValid()) continue;

                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // ファイル保存
                $file->storeAs('public/images/banner', $fileName);
                $storedFiles[] = $fileName;

                // DB登録
                $banner = Banner::create(['image' => $fileName]);
                $savedBanners[] = $banner;
            }

            DB::commit(); // 🔹 成功 → コミット

            return response()->json([
                'success' => true,
                'banners' => $savedBanners
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // 🔹 バリデーション失敗でもロールバック
            return response()->json([
                'success' => false,
                'errors'  => collect($e->errors())->flatten(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack(); // 🔹 DBをロールバック

            // 保存済みファイルがあれば削除
            foreach ($storedFiles ?? [] as $fileName) {
                if (Storage::exists('public/images/banner/' . $fileName)) {
                    Storage::delete('public/images/banner/' . $fileName);
                }
            }

            \Log::error('Banner登録エラー: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'サーバーエラーが発生しました'
            ], 500);
        }
    }

    // バナー削除
public function destroy($id)
{
    try {
        \DB::beginTransaction();

        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['success' => false]);
        }

        // ファイル削除（存在する場合）
        if (Storage::exists('public/images/banner/' . $banner->image)) {
            if (!Storage::delete('public/images/banner/' . $banner->image)) {
                throw new \Exception('ファイル削除に失敗しました。');
            }
        }

        // DB削除
        $banner->delete();

        \DB::commit();

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        \DB::rollBack();
        \Log::error('バナー削除エラー: '.$e->getMessage());

        return response()->json([
            'success' => false,
            'message' => '削除処理に失敗しました'
        ], 500);
    }
}

}
