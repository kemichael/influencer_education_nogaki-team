<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Grade extends Model
{
    use HasFactory;
    public function getGrade($gradeId) {
        // articlesテーブルからデータを取得
        $grade = DB::table('grades')->where('id', $gradeId)->first();
        return $grade;
    }
}
