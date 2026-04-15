<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;

class CurriculumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showCurriculumList(int $id)
    {
        $classes = SchoolClass::query()
            ->with('curriculums')
            ->academicOrder()
            ->get();

        return view('user.curriculum_list', compact('classes', 'id'));
    }
}
