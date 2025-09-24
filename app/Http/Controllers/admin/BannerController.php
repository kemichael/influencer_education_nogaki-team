<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

   public function register(Request $request)
{
    try {
        if (!$request->hasFile('banners')) {
            return response()->json([
                'success' => false,
                'message' => 'ファイルが選択されていません'
            ]); 
        }

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
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['success' => false]);
        }

        if (Storage::exists('public/images/banner/' . $banner->image)) {
            Storage::delete('public/images/banner/' . $banner->image);
        }

        $banner->delete();

        return response()->json(['success' => true]);
    }
}
