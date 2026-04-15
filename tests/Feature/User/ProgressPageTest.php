<?php

namespace Tests\Feature\User;

use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgressPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_view_progress_page(): void
    {
        $class = SchoolClass::create([
            'name' => '小学1年',
        ]);

        $user = User::factory()->create([
            'grade_id' => $class->id,
        ]);

        $curriculum = Curriculum::create([
            'grade_id' => $class->id,
            'title' => '国語',
            'thumbnail' => null,
            'description' => 'テスト授業',
            'video_url' => null,
            'always_delivery_flg' => true,
        ]);

        CurriculumProgress::create([
            'user_id' => $user->id,
            'curriculum_id' => $curriculum->id,
            'clear_flg' => true,
        ]);

        $response = $this->actingAs($user)->get('/user/progress');

        $response->assertOk();
        $response->assertSee('授業進捗');
        $response->assertSee('小学1年');
        $response->assertSee('国語');
        $response->assertSee('受講済み');
    }
}
