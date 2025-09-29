<?php

namespace App\Http\Controllers\User;

use App\Models\Curriculum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    // 一覧表示（初期表示も月で絞り込み）
    public function showCurriculumList(Request $request)
    {
        try {
            $grade = $request->query('grade', 1);
            $month = now()->format('Y-m');

            // モデルのスコープで取得
            $curriculums = Curriculum::byGradeAndMonth($grade, $month)->get();

            return view('user.curriculum_list', compact('curriculums'));

        } catch (\Exception $e) {
            \Log::error('Curriculum showCurriculumList error: '.$e->getMessage());
            abort(500, 'サーバーエラーが発生しました');
        }
    }

    // 月切り替え（AJAX用）
    public function getByMonth(Request $request)
    {
        try {
            $grade = $request->query('grade', 1);
            $month = $request->query('month', now()->format('Y-m'));

            // モデルの静的メソッドで即取得
            $curriculums = Curriculum::getCurriculumsByGradeAndMonth($grade, $month);

            return response()->json($curriculums);

        } catch (\Exception $e) {
            \Log::error('Curriculum getByMonth error: '.$e->getMessage());
            return response()->json(['error' => 'サーバーエラー'], 500);
        }
    }
}
