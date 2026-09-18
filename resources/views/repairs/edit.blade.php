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
        <form method="POST" action="{{ route('repairs.update', $repair) }}" class="space-y-6">
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
                            <option value="pending" {{ old('status', $repair->status) === 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                            <option value="in_progress" {{ old('status', $repair->status) === 'in_progress' ? 'selected' : '' }}>กำลังซ่อม</option>
                            <option value="waiting_parts" {{ old('status', $repair->status) === 'waiting_parts' ? 'selected' : '' }}>รออะไหล่</option>
                            <option value="completed" {{ old('status', $repair->status) === 'completed' ? 'selected' : '' }}>ซ่อมเสร็จสิ้น</option>
                            <option value="delivered" {{ old('status', $repair->status) === 'delivered' ? 'selected' : '' }}>ส่งมอบแล้ว</option>
                            <option value="cancelled" {{ old('status', $repair->status) === 'cancelled' ? 'selected' : '' }}>ยกเลิกงานซ่อม</option>
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

            <!-- Actions -->
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('repairs.show', $repair) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-medium transition-colors">
                    ยกเลิก
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm shadow-blue-500/20">
                    บันทึกการแก้ไข
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
