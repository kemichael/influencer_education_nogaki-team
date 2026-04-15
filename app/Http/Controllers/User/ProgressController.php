<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        $palette = [
            'progress-card--coral',
            'progress-card--sky',
            'progress-card--mint',
            'progress-card--butter',
            'progress-card--leaf',
            'progress-card--peach',
        ];

        $profileImageUrl = null;
        if (! empty($user->profile_image)) {
            $profileImageUrl = Str::startsWith($user->profile_image, ['http://', 'https://', '/'])
                ? $user->profile_image
                : asset('storage/' . ltrim($user->profile_image, '/'));
        }

        $totalCurriculums = $classes->sum(fn ($class) => $class->curriculums->count());
        $completedCount = count($clearCurriculumIds);

        $placeholderCards = ['授業枠 A', '授業枠 B', '授業枠 C', '授業枠 D', '授業枠 E', '授業枠 F'];

        $items = [
            ['label' => '時間割', 'disabled' => true],
            ['label' => '授業進捗', 'href' => route('show.progress'), 'active' => true],
            ['label' => 'プロフィール設定', 'href' => route('show.profile')],
        ];

        return view('user.curriculum_progress', compact(
            'user',
            'classes',
            'clearCurriculumIds',
            'palette',
            'profileImageUrl',
            'totalCurriculums',
            'completedCount',
            'placeholderCards',
            'items'
        ));
    }
}
