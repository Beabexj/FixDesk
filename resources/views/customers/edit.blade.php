@extends('layouts.app')

@section('title', 'แก้ไขข้อมูลลูกค้า')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">แก้ไขข้อมูลลูกค้า</h2>
            <p class="text-xs text-slate-500 mt-1">แก้ไขรายละเอียดลูกค้า: {{ $customer->name }}</p>
        </div>
        <a href="{{ route('customers.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; ย้อนกลับ
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
        <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ชื่อ-นามสกุล <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                       class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">เบอร์โทรศัพท์ <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required
                           class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">LINE ID</label>
                    <input type="text" name="line_id" value="{{ old('line_id', $customer->line_id) }}"
                           class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">อีเมล</label>
                <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                       class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ที่อยู่</label>
                <textarea name="address" rows="2"
                          class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('address', $customer->address) }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">หมายเหตุเพิ่มเติม</label>
                <textarea name="notes" rows="2"
                          class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100">{{ old('notes', $customer->notes) }}</textarea>
            </div>

            <div class="pt-3 flex items-center justify-between border-t border-slate-100">
                <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('ยืนยันการลบลูกค้ารายนี้หรือไม่?');">
                    <!-- Delete button handled separately -->
                </form>
                <div class="flex gap-3">
                    <x-button variant="secondary" href="{{ route('customers.index') }}">
                        ยกเลิก
                    </x-button>
                    <x-button variant="primary" type="submit">
                        บันทึกการแก้ไข
                    </x-button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
