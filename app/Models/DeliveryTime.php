<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DeliveryTime extends Model
{
    use HasFactory;
    public function getDeliveryTime($Id) {
        // articlesテーブルからデータを取得
        $deliveryTime = DB::table('delivery_times')->where('id', $Id)->first();
        return $deliveryTime;
    }
}
