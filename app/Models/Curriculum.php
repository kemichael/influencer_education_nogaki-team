<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'grade_id',
        'title',
        'thumbnail',
        'description',
        'video_url',
        'always_delivery_flg',
    ];

    protected $casts = [
        'always_delivery_flg' => 'boolean',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(\App\Models\SchoolClass::class, 'grade_id');
    }

    public function curriculumProgress(): HasMany
    {
        return $this->hasMany(\App\Models\CurriculumProgress::class, 'curriculum_id');
    }
}
