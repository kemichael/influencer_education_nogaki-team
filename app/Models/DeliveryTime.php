<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeliveryTime extends Model
{
    use HasFactory;
    public function getDeliveryTime($curriculumId) {
        // articlesテーブルからデータを取得
        $deliveryTime = DB::table('delivery_times')->where('curriculums_id', $curriculumId)->first();
        return $deliveryTime;
    }
    //リレーション定義　配信日時
    protected $table = 'delivery_times';
    protected $fillable = ['curriculums_id', 'delivery_from', 'delivery_to'];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class, 'curriculums_id');
    }
}