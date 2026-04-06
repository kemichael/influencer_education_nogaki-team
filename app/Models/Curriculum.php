<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    public function curriculumProgress()
    {
        return $this->hasMany(CurriculumProgress::class, 'curriculum_id');
    }
}
