<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_is_redirected_to_pending_approval(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/pending-approval');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'is_admin' => false,
            'is_approved' => false,
        ]);
    }

    public function test_approved_user_can_login_to_study_home(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
            'is_approved' => true,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/study');
        $this->assertAuthenticatedAs($user);
    }

    public function test_pending_user_is_redirected_to_pending_approval_on_login(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
            'is_approved' => false,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/pending-approval');
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_can_login_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'password' => 'password',
            'is_admin' => true,
            'is_approved' => true,
        ]);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
