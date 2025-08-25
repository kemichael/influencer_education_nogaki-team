<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CurriculumProgress extends Model
{
    public function registCurriculumProgress($data) {
    // 登録処理
    DB::table('curriculum_progress')->insert([
        'curriculums_id' => $data->curriculums_id,
        'users_id' => $data->users_id,
        'clear_flg' => $data->clear_flg,
    ]);
}
}
