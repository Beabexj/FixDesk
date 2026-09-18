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
        <form method="POST" action="{{ route('repairs.store') }}" class="space-y-6">
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

            <!-- Buttons -->
            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('repairs.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-medium transition-colors">
                    ยกเลิก
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition-colors shadow-sm shadow-blue-500/20">
                    บันทึกและออกใบแจ้งซ่อม
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
