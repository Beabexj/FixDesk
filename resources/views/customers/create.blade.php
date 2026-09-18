@extends('layouts.app')

@section('title', 'เพิ่มลูกค้าใหม่')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">เพิ่มข้อมูลลูกค้า</h2>
            <p class="text-xs text-slate-500 mt-1">กรอกข้อมูลลูกค้าเพื่อเปิดประวัติในระบบ</p>
        </div>
        <a href="{{ route('customers.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; ย้อนกลับ
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
        <form method="POST" action="{{ route('customers.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ชื่อ-นามสกุล <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                       placeholder="เช่น คุณสมศักดิ์ รักดี">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">เบอร์โทรศัพท์ <span class="text-rose-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                           class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                           placeholder="08X-XXX-XXXX">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">LINE ID</label>
                    <input type="text" name="line_id" value="{{ old('line_id') }}"
                           class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                           placeholder="ไอดีไลน์สำหรับติดต่อ">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">อีเมล</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                       placeholder="customer@example.com">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">ที่อยู่</label>
                <textarea name="address" rows="2"
                          class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                          placeholder="ที่อยู่สำหรับออกบิลหรือจัดส่ง">{{ old('address') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">หมายเหตุเพิ่มเติม</label>
                <textarea name="notes" rows="2"
                          class="w-full px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                          placeholder="ข้อมูลที่ต้องการบันทึกเพิ่มเติม">{{ old('notes') }}</textarea>
            </div>

            <div class="pt-3 flex justify-end gap-3 border-t border-slate-100">
                <a href="{{ route('customers.index') }}"
                   class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-sm font-medium transition-colors">
                    ยกเลิก
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-colors shadow-sm shadow-blue-500/20">
                    บันทึกข้อมูล
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
