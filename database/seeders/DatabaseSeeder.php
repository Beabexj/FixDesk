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

        // 3. Sample Repairs demonstrating full workflow:
        // [received -> inspection -> in_progress <-> waiting_parts -> completed -> delivered / cancelled]

        // 3.1 Completed
        $repair1 = Repair::firstOrCreate(
            ['repair_code' => 'FD-0001'],
            [
                'customer_id' => $customer1->id,
                'technician_id' => $tech1->id,
                'device_type' => 'โน้ตบุ๊ก (Laptop)',
                'brand' => 'ASUS',
                'model' => 'ROG Strix G15',
                'serial_number' => 'SN-ASUS998822',
                'problem_description' => 'เปิดเครื่องไม่ติด มีกลิ่นไหม้ตรงช่องเสียบชาร์จ',
                'accessories' => 'อะแดปเตอร์แท้ 1 อัน, กระเป๋าใส่โน้ตบุ๊ก',
                'repair_notes' => 'เปลี่ยนชิปภาคจ่ายไฟ เมนบอร์ดช็อต เทสต์รัน 12 ชม. ปกติ',
                'status' => Repair::STATUS_COMPLETED,
                'priority' => 'urgent',
                'estimated_cost' => 2500,
                'total_cost' => 2800,
                'received_at' => now()->subDays(5),
                'completed_at' => now()->subHours(6),
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

        // 3.2 In Progress
        Repair::firstOrCreate(
            ['repair_code' => 'FD-0002'],
            [
                'customer_id' => $customer2->id,
                'technician_id' => $tech2->id,
                'device_type' => 'เครื่องพิมพ์ (Printer)',
                'brand' => 'Epson',
                'model' => 'L3210',
                'serial_number' => 'EP-L3210-994',
                'problem_description' => 'กระดาษติดบ่อย และหมึกสีฟ้าไม่ออก',
                'accessories' => 'สายไฟ AC',
                'repair_notes' => 'กำลังล้างหัวพิมพ์และเปลี่ยนชุดลูกยางฟีดกระดาษ',
                'status' => Repair::STATUS_IN_PROGRESS,
                'priority' => 'normal',
                'estimated_cost' => 850,
                'total_cost' => 0,
                'received_at' => now()->subDays(2),
            ]
        );

        // 3.3 Waiting Parts
        Repair::firstOrCreate(
            ['repair_code' => 'FD-0003'],
            [
                'customer_id' => $customer3->id,
                'technician_id' => $tech1->id,
                'device_type' => 'คอมพิวเตอร์ตั้งโต๊ะ (PC Desktop)',
                'brand' => 'Custom Build',
                'model' => 'Core i7-13700K / RTX 4070',
                'serial_number' => 'DESK-CORP-01',
                'problem_description' => 'เครื่องค้างดับเองเวลาเรนเดอร์งาน 3D สงสัยพาวเวอร์ซัพพลายเสื่อม',
                'accessories' => 'เฉพาะตัวเคสเครื่อง',
                'repair_notes' => 'รออะไหล่พาวเวอร์ซัพพลาย 850W Gold สินค้าถึงพรุ่งนี้',
                'status' => Repair::STATUS_WAITING_PARTS,
                'priority' => 'high',
                'estimated_cost' => 4200,
                'total_cost' => 0,
                'received_at' => now()->subDays(3),
            ]
        );

        // 3.4 Inspection (ช่างกำลังตรวจเช็ค)
        Repair::firstOrCreate(
            ['repair_code' => 'FD-0004'],
            [
                'customer_id' => $customer1->id,
                'technician_id' => $tech2->id,
                'device_type' => 'โน้ตบุ๊ก (Laptop)',
                'brand' => 'Lenovo',
                'model' => 'IdeaPad 3',
                'serial_number' => 'LN-IP3-5511',
                'problem_description' => 'จอเป็นเส้นแนวนอนกระพริบ ขยับบานพับแล้วดับ',
                'accessories' => 'ตัวเครื่องพร้อมสายชาร์จ',
                'repair_notes' => 'กำลังแกะกรอบจอตรวจเช็คสายแพร์และชุด LCD Display',
                'status' => Repair::STATUS_INSPECTION,
                'priority' => 'normal',
                'estimated_cost' => 1500,
                'total_cost' => 0,
                'received_at' => now()->subHours(4),
            ]
        );

        // 3.5 Received (รับเครื่องใหม่เข้าระบบ)
        Repair::firstOrCreate(
            ['repair_code' => 'FD-0005'],
            [
                'customer_id' => $customer2->id,
                'technician_id' => null,
                'device_type' => 'โน้ตบุ๊ก (Laptop)',
                'brand' => 'Acer',
                'model' => 'Nitro 5',
                'serial_number' => 'AC-N5-8831',
                'problem_description' => 'พัดลมมีเสียงดังผิดปกติและเครื่องร้อนเร็วมาก',
                'accessories' => 'ตัวเครื่อง',
                'repair_notes' => 'รับเครื่องหน้าร้าน ยังไม่ได้จ่ายงานให้ช่าง',
                'status' => Repair::STATUS_RECEIVED,
                'priority' => 'normal',
                'estimated_cost' => 600,
                'total_cost' => 0,
                'received_at' => now()->subHours(1),
            ]
        );

        // 3.6 Delivered (ส่งมอบให้ลูกค้าเรียบร้อย)
        $repairDelivered = Repair::firstOrCreate(
            ['repair_code' => 'FD-0000'],
            [
                'customer_id' => $customer3->id,
                'technician_id' => $tech1->id,
                'device_type' => 'จอภาพ (Monitor)',
                'brand' => 'Dell',
                'model' => 'UltraSharp U2723QE',
                'serial_number' => 'DELL-U27-991',
                'problem_description' => 'พอร์ต Type-C ต่อไฟชาร์จเข้าแต่ภาพไม่ขึ้น',
                'accessories' => 'สายไฟ AC, สาย Type-C',
                'repair_notes' => 'เปลี่ยนชิป IC Multiplexer และส่งมอบลูกค้าทดสอบใช้งานได้ปกติ',
                'status' => Repair::STATUS_DELIVERED,
                'priority' => 'normal',
                'estimated_cost' => 1800,
                'total_cost' => 1800,
                'received_at' => now()->subDays(10),
                'completed_at' => now()->subDays(8),
            ]
        );

        RepairItem::firstOrCreate(
            ['repair_id' => $repairDelivered->id, 'item_name' => 'อะไหล่ชิป Type-C Controller'],
            [
                'type' => 'part',
                'quantity' => 1,
                'unit_price' => 1000,
                'total_price' => 1000,
            ]
        );

        RepairItem::firstOrCreate(
            ['repair_id' => $repairDelivered->id, 'item_name' => 'ค่าบริการซ่อมบอร์ด'],
            [
                'type' => 'service',
                'quantity' => 1,
                'unit_price' => 800,
                'total_price' => 800,
            ]
        );

        // 3.7 Cancelled (ลูกค้ายกเลิก/ซ่อมไม่คุ้ม)
        Repair::firstOrCreate(
            ['repair_code' => 'FD-0006'],
            [
                'customer_id' => $customer1->id,
                'technician_id' => $tech2->id,
                'device_type' => 'แท็บเล็ต (Tablet)',
                'brand' => 'iPad',
                'model' => 'iPad Air 4',
                'serial_number' => 'IPAD-A4-0019',
                'problem_description' => 'โดนน้ำทะเล เมนบอร์ดกัดกร่อนหนัก',
                'accessories' => 'ตัวเครื่อง',
                'repair_notes' => 'ตรวจเช็คแล้วชิปแรมและซีพียูช็อตทะลุ ค่าเปลี่ยนบอร์ดไม่คุ้ม ลูกค้าขอยกเลิกรับเครื่องคืน',
                'status' => Repair::STATUS_CANCELLED,
                'priority' => 'low',
                'estimated_cost' => 0,
                'total_cost' => 0,
                'received_at' => now()->subDays(4),
            ]
        );
    }
}
