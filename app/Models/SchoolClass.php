<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    public const DEFAULT_NAMES = [
        '小学1年',
        '小学2年',
        '小学3年',
        '小学4年',
        '小学5年',
        '小学6年',
        '中学1年',
        '中学2年',
        '中学3年',
        '高校1年',
        '高校2年',
        '高校3年',
    ];

    protected $table = 'classes';

    protected $fillable = [
        'name',
    ];

    public function scopeAcademicOrder($query)
    {
        $caseSql = collect(self::DEFAULT_NAMES)
            ->map(function ($name, $index) {
                $escapedName = str_replace("'", "''", $name);

                return "WHEN name = '{$escapedName}' THEN {$index}";
            })
            ->implode(' ');

        return $query
            ->orderByRaw("CASE {$caseSql} ELSE 999 END")
            ->orderBy('id');
    }

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class, 'grade_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'grade_id');
    }
}
