<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_change_password_page(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($user)->get('/password');

        $response->assertOk();
        $response->assertSee('change-password');
    }

    public function test_authenticated_user_can_change_password(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
            'is_approved' => true,
        ]);

        $response = $this->actingAs($user)->post('/password', [
            'current_password' => 'password',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response->assertRedirect('/password');
        $response->assertSessionHas('status', 'Your password has been updated.');
        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }

    public function test_password_change_requires_current_password_to_match(): void
    {
        $user = User::factory()->create([
            'password' => 'password',
            'is_approved' => true,
        ]);

        $response = $this->from('/password')->actingAs($user)->post('/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ]);

        $response->assertRedirect('/password');
        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
