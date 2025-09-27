<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';
    protected $fillable = ['title', 'thumbnail', 'description', 'video_url', 'alway_delivery_flg', 'grade_id', 'thumbnail',];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    protected $appends = ['thumbnail_url'];
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail 
            ? asset('storage/curriculums/' . $this->thumbnail) 
            : asset('images/default.png');
    }

    public function deliveryTimes()
    {
        return $this->hasMany(DeliveryTime::class, 'curriculums_id');
    }

    /**
     * 学年・月で取得するスコープ
     */
    public function scopeByGradeAndMonth($query, ?int $grade, ?string $month)
    {
        return $this->applyGradeAndMonthScope($query, $grade, $month);
    }

    /**
     * 学年・月でカリキュラムを取得（即結果取得用）
     */
    public static function getCurriculumsByGradeAndMonth(int $grade, ?string $month = null)
    {
        $instance = new self();
        $query = $instance->newQuery();
        return $instance->applyGradeAndMonthScope($query, $grade, $month)->get();
    }

    /**
     * 共通処理: 学年・月で絞り込むクエリ作成
     */
    protected function applyGradeAndMonthScope($query, ?int $grade, ?string $month)
    {
        [$year, $m] = explode('-', $month ?? now()->format('Y-m'));
        $year = (int)$year;
        $m    = (int)$m;

        $startOfMonth = date("Y-m-01 00:00:00", strtotime("$year-$m-01"));
        $endOfMonth   = date("Y-m-t 23:59:59", strtotime($startOfMonth));

        // deliveryTimes が該当月に存在するものに絞る
        $query->whereHas('deliveryTimes', function($q) use ($startOfMonth, $endOfMonth) {
            $q->where(function($q2) use ($startOfMonth, $endOfMonth) {
                $q2->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])
                   ->orWhereBetween('delivery_to', [$startOfMonth, $endOfMonth])
                   ->orWhere(function($q3) use ($startOfMonth, $endOfMonth) {
                       $q3->where('delivery_from', '<', $startOfMonth)
                          ->where('delivery_to', '>', $endOfMonth);
                   });
            });
        });

        // with で関連も一緒に取得（N+1 対策）
        $query->with(['deliveryTimes' => function($q) use ($startOfMonth, $endOfMonth) {
            $q->where(function($q2) use ($startOfMonth, $endOfMonth) {
                $q2->whereBetween('delivery_from', [$startOfMonth, $endOfMonth])
                   ->orWhereBetween('delivery_to', [$startOfMonth, $endOfMonth])
                   ->orWhere(function($q3) use ($startOfMonth, $endOfMonth) {
                       $q3->where('delivery_from', '<', $startOfMonth)
                          ->where('delivery_to', '>', $endOfMonth);
                   });
            });
        }]);

        if ($grade) {
            $query->where('grade_id', $grade);
        }

        return $query;
    }
}
