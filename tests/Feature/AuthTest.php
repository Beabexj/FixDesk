<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('เข้าสู่ระบบ');
    }

    public function test_unauthenticated_users_are_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create([
            'email' => 'testuser@fixdesk.local',
            'password' => bcrypt('password123'),
            'role' => 'technician',
            'is_active' => true,
        ]);

        $response = $this->post('/login', [
            'email' => 'testuser@fixdesk.local',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email' => 'testuser@fixdesk.local',
            'password' => bcrypt('password123'),
            'role' => 'technician',
            'is_active' => true,
        ]);

        $this->post('/login', [
            'email' => 'testuser@fixdesk.local',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create([
            'role' => 'technician',
        ]);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/login');
    }

    public function test_technician_cannot_access_users_management(): void
    {
        $technician = User::factory()->create([
            'role' => 'technician',
        ]);

        $response = $this->actingAs($technician)->get('/users');

        $response->assertStatus(403);
    }

    public function test_admin_can_access_users_management(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/users');

        $response->assertStatus(200);
    }
}
