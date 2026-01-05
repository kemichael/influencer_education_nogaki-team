<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Banner extends Model
{
     public function getList() {
        // bannersテーブルからデータを取得
        $banners = DB::table('banners')->get();

        return $banners;
    }
}
