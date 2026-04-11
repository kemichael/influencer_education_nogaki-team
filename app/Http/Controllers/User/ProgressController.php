<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProgress()
    {
        /** @var User $user */
        $user = Auth::user();
    
        $user->load([
            'schoolClass',
            'curriculumProgress',
        ]);
    
        $classes = SchoolClass::query()
            ->with('curriculums')
            ->academicOrder()
            ->get();
    
        $clearCurriculumIds = $user->curriculumProgress()
            ->where('clear_flg', true)
            ->pluck('curriculum_id')
            ->all();
    
        return view('user.curriculum_progress', compact('user', 'classes', 'clearCurriculumIds'));
    }
}
