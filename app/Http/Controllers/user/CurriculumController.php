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
            $gradeId = $request->query('grade', 1);
            $month   = now()->format('Y-m');

            [$year, $m] = $this->parseMonth($month);

            $startOfMonth = date("Y-m-01 00:00:00", strtotime("$year-$m-01"));
            $endOfMonth   = date("Y-m-t 23:59:59", strtotime($startOfMonth));

            $curriculums = Curriculum::where('grade_id', $gradeId)
                ->whereHas('deliveryTimes', function($q) use ($startOfMonth, $endOfMonth) {
                    $q->where(function($query) use ($startOfMonth, $endOfMonth) {
                        $query->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])
                              ->orWhereBetween('delivery_to', [$startOfMonth, $endOfMonth])
                              ->orWhere(function($q2) use ($startOfMonth, $endOfMonth) {
                                  $q2->where('delivery_from', '<', $startOfMonth)
                                     ->where('delivery_to', '>', $endOfMonth);
                              });
                    });
                })
                ->with(['deliveryTimes' => function($q) use ($startOfMonth, $endOfMonth) {
                    $q->where(function($query) use ($startOfMonth, $endOfMonth) {
                        $query->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])
                              ->orWhereBetween('delivery_to', [$startOfMonth, $endOfMonth])
                              ->orWhere(function($q2) use ($startOfMonth, $endOfMonth) {
                                  $q2->where('delivery_from', '<', $startOfMonth)
                                     ->where('delivery_to', '>', $endOfMonth);
                              });
                    });
                }])
                ->get();

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
            $month = $request->query('month', now()->format('Y-m'));
            $grade = $request->query('grade', 1);

            [$year, $m] = $this->parseMonth($month);

            $startOfMonth = date("Y-m-01 00:00:00", strtotime("$year-$m-01"));
            $endOfMonth   = date("Y-m-t 23:59:59", strtotime($startOfMonth));

            $curriculums = Curriculum::where('grade_id', $grade)
                ->whereHas('deliveryTimes', function($q) use ($startOfMonth, $endOfMonth) {
                    $q->where(function($query) use ($startOfMonth, $endOfMonth) {
                        $query->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])
                              ->orWhereBetween('delivery_to', [$startOfMonth, $endOfMonth])
                              ->orWhere(function($q2) use ($startOfMonth, $endOfMonth) {
                                  $q2->where('delivery_from', '<', $startOfMonth)
                                     ->where('delivery_to', '>', $endOfMonth);
                              });
                    });
                })
                ->with(['deliveryTimes' => function($q) use ($startOfMonth, $endOfMonth) {
                    $q->where(function($query) use ($startOfMonth, $endOfMonth) {
                        $query->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])
                              ->orWhereBetween('delivery_to', [$startOfMonth, $endOfMonth])
                              ->orWhere(function($q2) use ($startOfMonth, $endOfMonth) {
                                  $q2->where('delivery_from', '<', $startOfMonth)
                                     ->where('delivery_to', '>', $endOfMonth);
                              });
                    });
                }])
                ->get();

            // JSON で返す
            return response()->json($curriculums);

        } catch (\Exception $e) {
            \Log::error('Curriculum getByMonth error: '.$e->getMessage());
            return response()->json(['error' => 'サーバーエラー'], 500);
        }
    }

    /**
     * month パラメータを YYYY-MM 形式として安全に分解
     */
    private function parseMonth($month)
    {
        if (!$month || !str_contains($month, '-')) {
            $month = now()->format('Y-m');
        }
        [$year, $m] = explode('-', $month);
        return [(int)$year, (int)$m];
    }
}