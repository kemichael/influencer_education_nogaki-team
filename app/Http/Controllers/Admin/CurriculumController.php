<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CurriculumController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showCurriculumList()
    {
        return view('admin.curriculum_list');
    }

    public function showCurriculumCreate()
    {
        return view('admin.curriculum_create');
    }

    public function showCurriculumEdit(int $id)
    {
        return view('admin.curriculum_edit', compact('id'));
    }
}
