<?php

namespace Tests\Feature\User;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_logged_in_user_can_update_profile(): void
    {
        $oldClass = SchoolClass::create([
            'name' => '小学1年',
        ]);

        $newClass = SchoolClass::create([
            'name' => '小学2年',
        ]);

        $user = User::factory()->create([
            'grade_id' => $oldClass->id,
        ]);

        $response = $this->actingAs($user)->patch('/user/profile', [
            'name' => 'テスト太郎',
            'name_kana' => 'テストタロウ',
            'email' => 'test-profile@example.com',
            'grade_id' => $newClass->id,
        ]);

        $response->assertRedirect(route('show.profile'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'テスト太郎',
            'name_kana' => 'テストタロウ',
            'email' => 'test-profile@example.com',
            'grade_id' => $newClass->id,
        ]);
    }
}
