<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Repair;
use App\Models\RepairItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users & Technicians
        $admin = User::firstOrCreate(
            ['email' => 'admin@fixdesk.local'],
            [
                'name' => 'ผู้ดูแลระบบ (Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081-234-5678',
                'is_active' => true,
            ]
        );

        $tech1 = User::firstOrCreate(
            ['email' => 'somchai.tech@fixdesk.local'],
            [
                'name' => 'ช่างสมชาย ซ่อมไว',
                'password' => Hash::make('password'),
                'role' => 'technician',
                'phone' => '089-876-5432',
                'is_active' => true,
            ]
        );

        $tech2 = User::firstOrCreate(
            ['email' => 'wichai.tech@fixdesk.local'],
            [
                'name' => 'ช่างวิชัย อิเล็กทรอนิกส์',
                'password' => Hash::make('password'),
                'role' => 'technician',
                'phone' => '082-345-6789',
                'is_active' => true,
            ]
        );

        // 2. Customers
        $customer1 = Customer::firstOrCreate(
            ['phone' => '086-111-2222'],
            [
                'name' => 'คุณอนันต์ สุขสำราญ',
                'email' => 'anun@example.com',
                'line_id' => 'anun_fix',
                'address' => '123/45 ถ.พหลโยธิน แขวงลาดยาว เขตจตุจักร กทม.',
                'notes' => 'ลูกค้าประจำบริษัท',
            ]
        );

        $customer2 = Customer::firstOrCreate(
            ['phone' => '084-333-4444'],
            [
                'name' => 'คุณมาลี มีทรัพย์',
                'email' => 'malee@example.com',
                'line_id' => 'malee_shop',
                'address' => '88 หมู่ 2 ต.บางรักพัฒนา อ.บางบัวทอง จ.นนทบุรี',
                'notes' => 'โทรแจ้งก่อนส่งเครื่อง',
            ]
        );

        $customer3 = Customer::firstOrCreate(
            ['phone' => '081-555-6666'],
            [
                'name' => 'บริษัท ดิจิทัล โซลูชั่น จำกัด',
                'email' => 'contact@digitalsolution.th',
                'line_id' => '@digisol',
                'address' => '999 อาคารดิจิทัลทาวเวอร์ ชั้น 12 ถ.สีลม บางรัก กทม.',
                'notes' => 'ออกใบกำกับภาษีในนามบริษัท',
            ]
        );

        // 3. Sample Repairs
        $repair1 = Repair::firstOrCreate(
            ['repair_code' => 'FX-20260901-001'],
            [
                'customer_id' => $customer1->id,
                'technician_id' => $tech1->id,
                'device_type' => 'โน้ตบุ๊ก (Laptop)',
                'brand' => 'ASUS',
                'model' => 'ROG Strix G15',
                'serial_number' => 'SN-ASUS998822',
                'problem_description' => 'เปิดเครื่องไม่ติด มีกลิ่นไหม้ตรงช่องเสียบชาร์จ',
                'accessories' => 'อะแดปเตอร์แท้ 1 อัน, กระเป๋าใส่โน้ตบุ๊ก',
                'repair_notes' => 'เปลี่ยนชิปภาคจ่ายไฟ เมนบอร์ดช็อต',
                'status' => 'completed',
                'priority' => 'urgent',
                'estimated_cost' => 2500,
                'total_cost' => 2800,
                'received_at' => now()->subDays(5),
                'completed_at' => now()->subDays(1),
            ]
        );

        RepairItem::firstOrCreate(
            ['repair_id' => $repair1->id, 'item_name' => 'อะไหล่ชิป IC Power Management'],
            [
                'type' => 'part',
                'quantity' => 1,
                'unit_price' => 1500,
                'total_price' => 1500,
            ]
        );

        RepairItem::firstOrCreate(
            ['repair_id' => $repair1->id, 'item_name' => 'ค่าแรงตรวจซ่อมและบัดกรีระบบไฟเมนบอร์ด'],
            [
                'type' => 'service',
                'quantity' => 1,
                'unit_price' => 1300,
                'total_price' => 1300,
            ]
        );

        $repair2 = Repair::firstOrCreate(
            ['repair_code' => 'FX-20260910-002'],
            [
                'customer_id' => $customer2->id,
                'technician_id' => $tech2->id,
                'device_type' => 'เครื่องพิมพ์ (Printer)',
                'brand' => 'Epson',
                'model' => 'L3210',
                'serial_number' => 'EP-L3210-994',
                'problem_description' => 'กระดาษติดบ่อย และหมึกสีฟ้าไม่ออก',
                'accessories' => 'สายไฟ AC',
                'repair_notes' => 'ล้างหัวพิมพ์และเปลี่ยนลูกยางดึงกระดาษ',
                'status' => 'in_progress',
                'priority' => 'normal',
                'estimated_cost' => 850,
                'total_cost' => 0,
                'received_at' => now()->subDays(2),
            ]
        );

        $repair3 = Repair::firstOrCreate(
            ['repair_code' => 'FX-20260915-003'],
            [
                'customer_id' => $customer3->id,
                'technician_id' => $tech1->id,
                'device_type' => 'คอมพิวเตอร์ตั้งโต๊ะ (PC Desktop)',
                'brand' => 'Custom Build',
                'model' => 'Core i7-13700K / RTX 4070',
                'serial_number' => 'DESK-CORP-01',
                'problem_description' => 'เครื่องค้างดับเองเวลาเรนเดอร์งาน 3D สงสัยพาวเวอร์ซัพพลายเสื่อม',
                'accessories' => 'เฉพาะตัวเคสเครื่อง',
                'repair_notes' => 'รออะไหล่พาวเวอร์ซัพพลาย 850W Gold',
                'status' => 'waiting_parts',
                'priority' => 'high',
                'estimated_cost' => 4200,
                'total_cost' => 0,
                'received_at' => now()->subDay(),
            ]
        );
    }
}
