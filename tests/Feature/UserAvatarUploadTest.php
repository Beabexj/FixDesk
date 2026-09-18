<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserAvatarUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_user_avatar(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

        $response = $this->actingAs($admin)->post(route('users.store'), [
            'name' => 'Somchai Jaidee',
            'email' => 'somchai@fixdesk.local',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'technician',
            'phone' => '0812345678',
            'is_active' => true,
            'avatar' => $file,
        ]);

        $response->assertRedirect(route('users.index'));

        $user = User::where('email', 'somchai@fixdesk.local')->first();
        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
        $this->assertNotNull($user->avatar_url);
    }

    public function test_admin_can_update_user_avatar(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $oldFile = UploadedFile::fake()->image('old_avatar.jpg', 200, 200);
        $user = User::factory()->create([
            'avatar' => $oldFile->store('avatars', 'public'),
        ]);

        $newFile = UploadedFile::fake()->image('new_avatar.png', 200, 200);

        $response = $this->actingAs($admin)->put(route('users.update', $user), [
            'name' => 'Somchai Updated',
            'email' => $user->email,
            'role' => 'technician',
            'phone' => '0812345679',
            'is_active' => true,
            'avatar' => $newFile,
        ]);

        $response->assertRedirect(route('users.index'));

        $user->refresh();
        $this->assertNotNull($user->avatar);
        Storage::disk('public')->assertExists($user->avatar);
    }
}
