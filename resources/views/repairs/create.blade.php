@extends('layouts.app')

@section('title', 'เปิดใบแจ้งซ่อมใหม่')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">เปิดใบแจ้งซ่อมใหม่</h2>
            <p class="text-xs text-slate-500 mt-1">กรอกรายละเอียดการรับเครื่องและอาการเสีย</p>
        </div>
        <a href="{{ route('repairs.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; กลับหน้ารายการ
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
        <form method="POST" action="{{ route('repairs.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Customer & Technician Selection -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">1. ข้อมูลลูกค้าและผู้รับผิดชอบ</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-xs font-semibold text-slate-700 uppercase tracking-wider">ลูกค้าผู้ส่งซ่อม <span class="text-rose-500">*</span></label>
                            <a href="{{ route('customers.create') }}" target="_blank" class="text-[11px] text-blue-600 hover:underline">+ เพิ่มลูกค้าใหม่</a>
                        </div>
                        <select name="customer_id" required class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">-- เลือกลูกค้า --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ (old('customer_id') == $customer->id || request('customer_id') == $customer->id) ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">มอบหมายช่างซ่อม</label>
                        <select name="technician_id" class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">-- ยังไม่ระบุ / มอบหมายภายหลัง --</option>
                            @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}" {{ old('technician_id') == $tech->id ? 'selected' : '' }}>
                                    {{ $tech->name }} ({{ $tech->role }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Section 2: Device Information -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">2. ข้อมูลอุปกรณ์</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ประเภทอุปกรณ์ <span class="text-rose-500">*</span></label>
                        <input type="text" name="device_type" value="{{ old('device_type') }}" required
                               list="device_types"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="เช่น โน้ตบุ๊ก, PC, จอภาพ">
                        <datalist id="device_types">
                            <option value="โน้ตบุ๊ก (Laptop)">
                            <option value="คอมพิวเตอร์ตั้งโต๊ะ (PC)">
                            <option value="จอภาพ (Monitor)">
                            <option value="เครื่องพิมพ์ (Printer)">
                            <option value="สมาร์ตโฟน (Smartphone)">
                            <option value="แท็บเล็ต (Tablet)">
                            <option value="อุปกรณ์เครือข่าย (Network Router)">
                        </datalist>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ยี่ห้อ (Brand)</label>
                        <input type="text" name="brand" value="{{ old('brand') }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="เช่น ASUS, Dell, HP, Apple">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">รุ่น (Model)</label>
                        <input type="text" name="model" value="{{ old('model') }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="เช่น VivoBook 15, Inspiron">
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Serial Number / เลขประจำเครื่อง</label>
                        <input type="text" name="serial_number" value="{{ old('serial_number') }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="S/N บนตัวเครื่อง">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">อุปกรณ์ที่นำมาด้วย (Accessories)</label>
                        <input type="text" name="accessories" value="{{ old('accessories') }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="เช่น สายชาร์จ, กระเป๋า, กล่อง">
                    </div>
                </div>
            </div>

            <!-- Section 3: Problem & Status -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">3. รายละเอียดอาการและสถานะ</h3>
                
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">อาการเสียที่ลูกค้าแจ้ง <span class="text-rose-500">*</span></label>
                    <textarea name="problem_description" rows="3" required
                              class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                              placeholder="ระบุอาการผิดปกติ เช่น เปิดไม่ติด มีเสียงร้องเตือน เครื่องร้อนดับเอง">{{ old('problem_description') }}</textarea>
                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ระดับความเร่งด่วน <span class="text-rose-500">*</span></label>
                        <select name="priority" required class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="normal" {{ old('priority', 'normal') === 'normal' ? 'selected' : '' }}>ปกติ (Normal)</option>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>ต่ำ (Low)</option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>ด่วน (High)</option>
                            <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>ด่วนที่สุด (Urgent)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">สถานะเริ่มต้น <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="received" {{ old('status', 'received') === 'received' ? 'selected' : '' }}>รับเครื่อง (Received)</option>
                            <option value="inspection" {{ old('status') === 'inspection' ? 'selected' : '' }}>ตรวจสอบ (Inspection)</option>
                            <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>กำลังซ่อม (In Progress)</option>
                            <option value="waiting_parts" {{ old('status') === 'waiting_parts' ? 'selected' : '' }}>รออะไหล่ (Waiting Parts)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ประเมินราคาเบื้องต้น (บาท)</label>
                        <input type="number" step="0.01" name="estimated_cost" value="{{ old('estimated_cost', 0) }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                               placeholder="0.00">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">หมายเหตุช่าง / บันทึกภายใน</label>
                    <textarea name="repair_notes" rows="2"
                              class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                              placeholder="บันทึกสภาพเครื่องก่อนแกะ หรือข้อควรระวัง">{{ old('repair_notes') }}</textarea>
                </div>
            </div>

            <!-- Section 4: Device Photo (สภาพเครื่อง) -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">4. รูปถ่ายสภาพเครื่อง (ก่อนซ่อม)</h3>
                <div class="space-y-3">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">แนบรูปถ่ายอุปกรณ์ / รอยตำหนิ / สภาพตอนรับเครื่อง</label>
                    <div class="flex flex-col sm:flex-row items-start gap-4">
                        <!-- Upload Drag/Drop Box -->
                        <label class="flex-1 w-full flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-2xl cursor-pointer bg-slate-50/50 hover:bg-blue-50/20 transition-all text-center">
                            <i class="bi bi-camera fs-2 text-slate-400 mb-2"></i>
                            <span class="text-sm font-semibold text-slate-700">คลิกเพื่อเลือกไฟล์รูปภาพอุปกรณ์</span>
                            <span class="text-xs text-slate-400 mt-1">รองรับไฟล์ JPG, PNG, WEBP สูงสุด 5MB</span>
                            <input type="file" id="deviceImageInput" name="device_image" accept="image/*" onchange="previewDeviceImage(event)" class="hidden">
                        </label>

                        <!-- Preview Box -->
                        <div id="deviceImagePreviewContainer" class="hidden w-full sm:w-48 h-36 rounded-xl border border-slate-200 overflow-hidden relative shadow-xs flex-shrink-0 bg-slate-100">
                            <img id="deviceImagePreviewImg" src="" alt="Device Preview" class="w-full h-full object-cover">
                            <button type="button" onclick="clearDeviceImagePreview()" class="absolute top-2 right-2 w-6 h-6 rounded-full bg-slate-900/75 text-white flex items-center justify-center text-xs hover:bg-rose-600 transition-colors shadow-sm">
                                &times;
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="secondary" href="{{ route('repairs.index') }}">
                    ยกเลิก
                </x-button>
                <x-button variant="primary" type="submit">
                    บันทึกและออกใบแจ้งซ่อม
                </x-button>
            </div>
        </form>
    </div>
</div>

<script>
function previewDeviceImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('deviceImagePreviewContainer');
            const img = document.getElementById('deviceImagePreviewImg');
            img.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function clearDeviceImagePreview() {
    const input = document.getElementById('deviceImageInput');
    const container = document.getElementById('deviceImagePreviewContainer');
    const img = document.getElementById('deviceImagePreviewImg');
    input.value = '';
    img.src = '';
    container.classList.add('hidden');
}
</script>
@endsection
