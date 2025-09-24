<?php

namespace App\Http\Controllers\Admin;

use App\Models\Curriculum;
use App\Models\DeliveryTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    // カリキュラム作成フォーム
    public function create()
    {
        return view('admin.curriculums.create');
    }

    // カリキュラム登録処理
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'video_url'     => 'nullable|url',
            'alway_delivery_flg' => 'nullable|boolean',
            'grade_id'      => 'required|integer',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'delivery_from.*' => 'required|date',
            'delivery_to.*'   => 'required|date',
        ]);

        // サムネイル保存（curriculums フォルダに保存）
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('images/curriculums', 'public');
        }

        // カリキュラム登録
        $curriculum = Curriculum::create([
            'title'              => $validated['title'],
            'thumbnail'          => $thumbnailPath,
            'description'        => $validated['description'] ?? null,
            'video_url'          => $validated['video_url'] ?? null,
            'alway_delivery_flg' => $validated['alway_delivery_flg'] ?? 0,
            'grade_id'           => $validated['grade_id'],
        ]);

        // 配信時間登録
        if ($request->delivery_from) {
            foreach ($request->delivery_from as $index => $from) {
                $to = $request->delivery_to[$index] ?? null;

                if ($to && $to <= $from) {
                    return back()
                        ->withErrors(['delivery_to.' . $index => '終了時間は開始時間より後にしてください'])
                        ->withInput();
                }

                if ($to) {
                    DeliveryTime::create([
                        'curriculum_id' => $curriculum->id,
                        'delivery_from' => $from,
                        'delivery_to'   => $to,
                    ]);
                }
            }
        }

        return redirect()->route('admin.curriculums.index')
                         ->with('success', 'カリキュラムを登録しました');
    }

    // カリキュラム一覧（管理者用）
    public function index(Request $request)
    {
        $gradeId = $request->grade ?? 1;
        $curriculums = Curriculum::with('deliveryTimes')
                        ->where('grade_id', $gradeId)
                        ->get();

        return view('admin.curriculums.index', compact('curriculums'));
    }
}
