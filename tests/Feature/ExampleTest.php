<?php

namespace Tests\Feature;

use App\Models\JlptLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_can_view_the_kmm_japanese_home_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('KMM JAPANESE');
        $response->assertSee('"component":"home"', false);
    }

    public function test_pending_users_see_the_pending_approval_page(): void
    {
        $user = User::factory()->create(['is_approved' => false]);

        $response = $this->actingAs($user)->get('/pending-approval');

        $response->assertOk();
        $response->assertSee('"component":"pending-approval"', false);
    }

    public function test_non_admin_dashboard_redirects_to_study_home(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $level = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner',
        ]);
        $user->accessibleJlptLevels()->attach($level->id);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertRedirect('/study');
    }

    public function test_admin_dashboard_includes_progress_tracking_data(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('"lessonCompletionRate"', false);
        $response->assertSee('"recentQuizAttempts"', false);
    }
}
