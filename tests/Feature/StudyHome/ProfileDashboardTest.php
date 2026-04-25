<?php

namespace Tests\Feature\StudyHome;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_study_home_includes_study_launcher_cards(): void
    {
        $user = User::factory()->create(['is_approved' => true]);

        $response = $this->actingAs($user)->get('/study');

        $response->assertOk();
        $response->assertSee('"lessons":"http:\/\/localhost\/lessons"', false);
        $response->assertSee('"vocabulary":"http:\/\/localhost\/vocabulary"', false);
        $response->assertSee('"kanji":"http:\/\/localhost\/kanji"', false);
        $response->assertSee('"flashcards":"http:\/\/localhost\/flashcards"', false);
    }
}
