<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Banner;
use App\Http\Requests\BannerRequest;

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
    public function register(BannerRequest $request)
{
    try {
        $savedBanners = [];

        foreach ($request->file('banners') as $file) {
            if (!$file->isValid()) continue;

            $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->storeAs('public/images/banner', $fileName);

            $banner = Banner::create(['image' => $fileName]);
            $savedBanners[] = $banner;
        }

        return response()->json([
            'success' => true,
            'banners' => $savedBanners
        ]);

    } catch (\Exception $e) {
        \Log::error('Banner登録エラー: '.$e->getMessage());
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
