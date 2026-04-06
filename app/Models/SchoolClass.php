<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    public function curriculums ()
    {
        return $this->hasMany(Curriculum::class, 'grade_id');
    }
}

