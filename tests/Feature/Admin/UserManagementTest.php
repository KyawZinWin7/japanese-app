<?php

namespace Tests\Feature\Admin;

use App\Models\JlptLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_learner_with_assigned_jlpt_levels(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $n5 = JlptLevel::create([
            'name' => 'N5',
            'slug' => 'n5',
            'sort_order' => 5,
            'description' => 'Beginner',
        ]);
        $n4 = JlptLevel::create([
            'name' => 'N4',
            'slug' => 'n4',
            'sort_order' => 4,
            'description' => 'Elementary',
        ]);

        $response = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Learner User',
            'email' => 'learner@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'is_admin' => '0',
            'is_approved' => '1',
            'jlpt_levels' => [$n5->id, $n4->id],
        ]);

        $response->assertRedirect('/admin/users');

        $userId = User::where('email', 'learner@example.com')->value('id');

        $this->assertNotNull($userId);
        $this->assertDatabaseHas('users', [
            'id' => $userId,
            'is_approved' => true,
        ]);
        $this->assertDatabaseHas('jlpt_level_user', [
            'user_id' => $userId,
            'jlpt_level_id' => $n5->id,
        ]);
        $this->assertDatabaseHas('jlpt_level_user', [
            'user_id' => $userId,
            'jlpt_level_id' => $n4->id,
        ]);
    }

    public function test_admin_can_approve_a_registered_learner(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $learner = User::factory()->create(['is_admin' => false, 'is_approved' => false]);

        $response = $this->actingAs($admin)->post('/admin/approvals/'.$learner->id.'/approve');

        $response->assertRedirect('/admin/approvals');
        $this->assertDatabaseHas('users', [
            'id' => $learner->id,
            'is_approved' => true,
        ]);
    }

    public function test_admin_can_reject_a_pending_registered_learner(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        $learner = User::factory()->create(['is_admin' => false, 'is_approved' => false]);

        $response = $this->actingAs($admin)->post('/admin/approvals/'.$learner->id.'/reject');

        $response->assertRedirect('/admin/approvals');
        $this->assertDatabaseMissing('users', [
            'id' => $learner->id,
        ]);
    }

    public function test_admin_can_filter_approval_page_by_search_and_status(): void
    {
        $admin = User::factory()->create(['is_admin' => true, 'is_approved' => true]);
        User::factory()->create(['name' => 'Pending Learner', 'email' => 'pending@example.com', 'is_admin' => false, 'is_approved' => false]);
        User::factory()->create(['name' => 'Approved Learner', 'email' => 'approved@example.com', 'is_admin' => false, 'is_approved' => true]);

        $response = $this->actingAs($admin)->get('/admin/approvals?status=approved&search=approved@example.com');

        $response->assertOk();
        $response->assertSee('approved@example.com');
        $response->assertDontSee('pending@example.com');
    }

    public function test_non_admin_users_cannot_access_user_management(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/users');

        $response->assertForbidden();
    }
}
