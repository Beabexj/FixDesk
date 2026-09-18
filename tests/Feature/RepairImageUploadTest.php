<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RepairImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_repair_with_device_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['is_active' => true]);
        $customer = Customer::create([
            'name' => 'John Doe',
            'phone' => '0891234567',
        ]);

        $file = UploadedFile::fake()->image('broken_laptop.jpg', 800, 600);

        $response = $this->actingAs($user)->post(route('repairs.store'), [
            'customer_id' => $customer->id,
            'device_type' => 'Notebook',
            'brand' => 'Dell',
            'model' => 'XPS 13',
            'problem_description' => 'จอฟ้า เปิดไม่ติด',
            'priority' => 'high',
            'status' => 'received',
            'estimated_cost' => 1500,
            'device_image' => $file,
        ]);

        $repair = Repair::first();
        $this->assertNotNull($repair);
        $response->assertRedirect(route('repairs.show', $repair));

        $this->assertNotNull($repair->device_image);
        Storage::disk('public')->assertExists($repair->device_image);
        $this->assertNotNull($repair->device_image_url);
    }

    public function test_user_can_update_and_clear_device_image(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['is_active' => true]);
        $customer = Customer::create([
            'name' => 'Jane Doe',
            'phone' => '0897654321',
        ]);

        $oldFile = UploadedFile::fake()->image('old_photo.jpg', 400, 400);
        $oldPath = $oldFile->store('repairs', 'public');

        $repair = Repair::create([
            'repair_code' => 'REP-TEST-01',
            'customer_id' => $customer->id,
            'device_type' => 'Smartphone',
            'brand' => 'Apple',
            'model' => 'iPhone 13',
            'problem_description' => 'แบตบวม',
            'priority' => 'normal',
            'status' => 'received',
            'device_image' => $oldPath,
        ]);

        // Test clearing the image
        $response = $this->actingAs($user)->put(route('repairs.update', $repair), [
            'customer_id' => $customer->id,
            'device_type' => 'Smartphone',
            'problem_description' => 'แบตบวม เปลี่ยนแบต',
            'priority' => 'normal',
            'status' => 'in_progress',
            'clear_device_image' => true,
        ]);

        $response->assertRedirect(route('repairs.show', $repair));
        $repair->refresh();

        $this->assertNull($repair->device_image);
        Storage::disk('public')->assertMissing($oldPath);
    }
}
