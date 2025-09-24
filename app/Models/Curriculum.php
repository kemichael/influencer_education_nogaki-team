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

    protected $appends = ['thumbnail_url']; // JSON で自動的に追加される
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/curriculums/' . $this->thumbnail);
        }
        return asset('images/default.png');
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
        [$year, $m] = explode('-', $month ?? now()->format('Y-m'));
        $m = (int)$m;

        $startOfMonth = date("Y-m-01 00:00:00", strtotime("$year-$m-01"));
        $endOfMonth   = date("Y-m-t 23:59:59", strtotime($startOfMonth));

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
