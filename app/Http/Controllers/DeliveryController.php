<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CurriculumProgress;
use App\Models\Curriculum;
use App\Models\DeliveryTime;
use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    public function showDelivery(Request $request) {
        $modelCurri = new Curriculum();
        $curriculum = $modelCurri->getCurriculum($request->curriculum_id); // ここで1件だけ返す
        $modelDeliveryTime = new DeliveryTime();
        $deliveryTime = $modelDeliveryTime->getDeliveryTime($request->curriculum_id); // ここで1件だけ返す
        // 例: $curriculum->grade_id で学年IDを取得
        $modelGrade = new Grade();
        $grade = $modelGrade->getGrade($curriculum->grade_id); // 学年情報を取得
        return view('delivery', [
            'curriculum' => $curriculum,'grade' => $grade, 'deliveryTime' => $deliveryTime
        ]);
    }       
    public function registCurriculumProgress(Request $request) {

    // トランザクション開始
    DB::beginTransaction();

    try {
        // 登録処理呼び出し
        $model = new CurriculumProgress();
        $model->registCurriculumProgress($request);
        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        return back();
    }

    // 処理が完了したらregistにリダイレクト
    return redirect(route('show.curriculum_progress'));
}
}
