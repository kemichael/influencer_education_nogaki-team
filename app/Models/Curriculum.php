<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Curriculum extends Model
{

    use HasFactory;

    public function getCurriculum($curriculumId) {
        // articlesテーブルからデータを取得
        $curriculum = DB::table('curriculums')->where('id', $curriculumId)->first();
        return $curriculum;
    }
}
