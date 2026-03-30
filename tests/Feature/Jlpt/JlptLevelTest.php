<?php

namespace Tests\Feature\Jlpt;

use App\Models\JlptLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JlptLevelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_levels_page(): void
    {
        JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner level',
        ]);

        $response = $this->get('/levels');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_approved_users_can_view_only_assigned_levels(): void
    {
        $user = User::factory()->create(['is_approved' => true]);
        $n5 = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner level',
        ]);
        JlptLevel::create([
            'name' => 'N4',
            'slug' => 'n4',
            'sort_order' => 4,
            'description' => 'Elementary level',
        ]);

        $user->accessibleJlptLevels()->attach($n5->id);

        $response = $this->actingAs($user)->get('/levels');

        $response->assertOk();
        $response->assertSee('N5');
        $response->assertDontSee('N4');
    }

    public function test_authenticated_admin_users_can_create_a_level_from_admin(): void
    {
        $user = User::factory()->create(['is_admin' => true, 'is_approved' => true]);

        $response = $this->actingAs($user)->post('/admin/levels', [
            'name' => 'N4',
            'slug' => 'n4',
            'sort_order' => 4,
            'description' => 'Elementary level',
        ]);

        $response->assertRedirect('/admin/levels');
        $this->assertDatabaseHas('jlpt_levels', [
            'name' => 'N4',
            'slug' => 'n4',
        ]);
    }
}
