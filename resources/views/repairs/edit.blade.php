@extends('layouts.app')

@section('title', 'แก้ไขใบแจ้งซ่อม - ' . $repair->repair_code)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">แก้ไขใบแจ้งซ่อม ({{ $repair->repair_code }})</h2>
            <p class="text-xs text-slate-500 mt-1">อัปเดตสถานะและข้อมูลความคืบหน้างานซ่อม</p>
        </div>
        <a href="{{ route('repairs.show', $repair) }}" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; ดูรายละเอียด
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
        <form method="POST" action="{{ route('repairs.update', $repair) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Section 1: Customer & Technician Selection -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">1. ลูกค้าและช่างผู้รับผิดชอบ</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ลูกค้า <span class="text-rose-500">*</span></label>
                        <select name="customer_id" required class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $repair->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ $customer->phone }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">มอบหมายช่างซ่อม</label>
                        <select name="technician_id" class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">-- ยังไม่ระบุ --</option>
                            @foreach($technicians as $tech)
                                <option value="{{ $tech->id }}" {{ old('technician_id', $repair->technician_id) == $tech->id ? 'selected' : '' }}>
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
                        <input type="text" name="device_type" value="{{ old('device_type', $repair->device_type) }}" required
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ยี่ห้อ</label>
                        <input type="text" name="brand" value="{{ old('brand', $repair->brand) }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">รุ่น</label>
                        <input type="text" name="model" value="{{ old('model', $repair->model) }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">Serial Number</label>
                        <input type="text" name="serial_number" value="{{ old('serial_number', $repair->serial_number) }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">อุปกรณ์ที่นำมาด้วย</label>
                        <input type="text" name="accessories" value="{{ old('accessories', $repair->accessories) }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>
            </div>

            <!-- Section 3: Problem & Status Management -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">3. ปรับปรุงสถานะและค่าใช้จ่าย</h3>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">อาการเสียที่ลูกค้าแจ้ง <span class="text-rose-500">*</span></label>
                    <textarea name="problem_description" rows="3" required
                              class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('problem_description', $repair->problem_description) }}</textarea>
                </div>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">สถานะงานซ่อม <span class="text-rose-500">*</span></label>
                        <select name="status" required class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="received" {{ old('status', $repair->status) === 'received' ? 'selected' : '' }}>รับเครื่อง (Received)</option>
                            <option value="inspection" {{ old('status', $repair->status) === 'inspection' ? 'selected' : '' }}>ตรวจสอบ (Inspection)</option>
                            <option value="in_progress" {{ old('status', $repair->status) === 'in_progress' ? 'selected' : '' }}>กำลังซ่อม (In Progress)</option>
                            <option value="waiting_parts" {{ old('status', $repair->status) === 'waiting_parts' ? 'selected' : '' }}>รออะไหล่ (Waiting Parts)</option>
                            <option value="completed" {{ old('status', $repair->status) === 'completed' ? 'selected' : '' }}>ซ่อมเสร็จ (Completed)</option>
                            <option value="delivered" {{ old('status', $repair->status) === 'delivered' ? 'selected' : '' }}>ส่งมอบแล้ว (Delivered)</option>
                            <option value="cancelled" {{ old('status', $repair->status) === 'cancelled' ? 'selected' : '' }}>ยกเลิก (Cancelled)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ความเร่งด่วน <span class="text-rose-500">*</span></label>
                        <select name="priority" required class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="low" {{ old('priority', $repair->priority) === 'low' ? 'selected' : '' }}>ต่ำ</option>
                            <option value="normal" {{ old('priority', $repair->priority) === 'normal' ? 'selected' : '' }}>ปกติ</option>
                            <option value="high" {{ old('priority', $repair->priority) === 'high' ? 'selected' : '' }}>ด่วน</option>
                            <option value="urgent" {{ old('priority', $repair->priority) === 'urgent' ? 'selected' : '' }}>ด่วนที่สุด</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ประเมินราคา (บาท)</label>
                        <input type="number" step="0.01" name="estimated_cost" value="{{ old('estimated_cost', $repair->estimated_cost) }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ยอดชำระจริง (บาท)</label>
                        <input type="number" step="0.01" name="total_cost" value="{{ old('total_cost', $repair->total_cost) }}"
                               class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">บันทึกความคืบหน้าของช่าง</label>
                    <textarea name="repair_notes" rows="3"
                              class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                              placeholder="ระบุสิ่งที่ตรวจพบและขั้นตอนการซ่อมที่ได้ทำไปแล้ว">{{ old('repair_notes', $repair->repair_notes) }}</textarea>
                </div>
            </div>

            <!-- Section 4: Device Photo (รูปถ่ายสภาพเครื่อง) -->
            <div>
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">4. รูปถ่ายสภาพเครื่อง</h3>
                <div class="space-y-4">
                    @if($repair->device_image_url)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200">
                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">รูปภาพปัจจุบันในระบบ</label>
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <a href="{{ $repair->device_image_url }}" target="_blank" class="block w-40 h-28 rounded-xl overflow-hidden border border-slate-300 shadow-xs relative group flex-shrink-0">
                                    <img src="{{ $repair->device_image_url }}" alt="รูปภาพเครื่องปัจจุบัน" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-medium transition-opacity">
                                        <i class="bi bi-arrows-fullscreen mr-1"></i> ดูรูปเต็ม
                                    </div>
                                </a>
                                <div class="space-y-2">
                                    <p class="text-xs text-slate-500">คลิกที่รูปภาพเพื่อเปิดดูภาพขนาดเต็มในแท็บใหม่</p>
                                    <label class="inline-flex items-center gap-2 text-xs font-semibold text-rose-600 cursor-pointer bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg border border-rose-200 transition-colors">
                                        <input type="checkbox" name="clear_device_image" value="1" class="rounded border-rose-300 text-rose-600 focus:ring-rose-500">
                                        <span>ลบรูปภาพนี้ออกจากระบบ</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                            {{ $repair->device_image_url ? 'อัปโหลดรูปภาพใหม่เพื่อแทนที่ (ถ้าต้องการเปลี่ยน)' : 'แนบรูปถ่ายอุปกรณ์ / สภาพตอนรับเครื่อง' }}
                        </label>
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <!-- Upload Box -->
                            <label class="flex-1 w-full flex flex-col items-center justify-center p-6 border-2 border-dashed border-slate-200 hover:border-blue-400 rounded-2xl cursor-pointer bg-slate-50/50 hover:bg-blue-50/20 transition-all text-center">
                                <i class="bi bi-cloud-arrow-up fs-2 text-slate-400 mb-2"></i>
                                <span class="text-sm font-semibold text-slate-700">คลิกเพื่อเลือกไฟล์รูปภาพใหม่</span>
                                <span class="text-xs text-slate-400 mt-1">รองรับไฟล์ JPG, PNG, WEBP สูงสุด 5MB</span>
                                <input type="file" id="editDeviceImageInput" name="device_image" accept="image/*" onchange="previewEditDeviceImage(event)" class="hidden">
                            </label>

                            <!-- Preview Box -->
                            <div id="editDeviceImagePreviewContainer" class="hidden w-full sm:w-48 h-36 rounded-xl border border-slate-200 overflow-hidden relative shadow-xs flex-shrink-0 bg-slate-100">
                                <img id="editDeviceImagePreviewImg" src="" alt="New Device Preview" class="w-full h-full object-cover">
                                <button type="button" onclick="clearEditDeviceImagePreview()" class="absolute top-2 right-2 w-6 h-6 rounded-full bg-slate-900/75 text-white flex items-center justify-center text-xs hover:bg-rose-600 transition-colors shadow-sm">
                                    &times;
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <x-button variant="secondary" href="{{ route('repairs.show', $repair) }}">
                    ยกเลิก
                </x-button>
                <x-button variant="primary" type="submit">
                    บันทึกการแก้ไข
                </x-button>
            </div>
        </form>
    </div>
</div>

<script>
function previewEditDeviceImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('editDeviceImagePreviewContainer');
            const img = document.getElementById('editDeviceImagePreviewImg');
            img.src = e.target.result;
            container.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function clearEditDeviceImagePreview() {
    const input = document.getElementById('editDeviceImageInput');
    const container = document.getElementById('editDeviceImagePreviewContainer');
    const img = document.getElementById('editDeviceImagePreviewImg');
    input.value = '';
    img.src = '';
    container.classList.add('hidden');
}
</script>
@endsection
