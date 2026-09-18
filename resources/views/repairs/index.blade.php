@extends('layouts.app')

@section('title', 'รายการใบแจ้งซ่อม')

@section('content')
<div class="space-y-6">
    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">รายการใบแจ้งซ่อมทั้งหมด</h2>
            <p class="text-xs text-slate-500 mt-1">ติดตามสถานะงานซ่อมอุปกรณ์ทุกรายการ</p>
        </div>

        <a href="{{ route('repairs.create') }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-medium transition-colors shadow-sm shadow-blue-500/20 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            เปิดใบแจ้งซ่อมใหม่
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('repairs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="ค้นหารหัสใบซ่อม, อุปกรณ์, หรือลูกค้า..."
                       class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:bg-white focus:border-blue-500">
            </div>

            <div>
                <select name="status" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:bg-white focus:border-blue-500">
                    <option value="">-- ทุกสถานะ --</option>
                    <option value="received" {{ request('status') === 'received' ? 'selected' : '' }}>รับเครื่อง (Received)</option>
                    <option value="inspection" {{ request('status') === 'inspection' ? 'selected' : '' }}>ตรวจสอบ (Inspection)</option>
                    <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>กำลังซ่อม (In Progress)</option>
                    <option value="waiting_parts" {{ request('status') === 'waiting_parts' ? 'selected' : '' }}>รออะไหล่ (Waiting Parts)</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>ซ่อมเสร็จ (Completed)</option>
                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>ส่งมอบแล้ว (Delivered)</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>ยกเลิก (Cancelled)</option>
                </select>
            </div>

            <div>
                <select name="priority" class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-hidden focus:bg-white focus:border-blue-500">
                    <option value="">-- ทุกระดับความสำคัญ --</option>
                    <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>ด่วนที่สุด (Urgent)</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>ด่วน (High)</option>
                    <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>ปกติ (Normal)</option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>ต่ำ (Low)</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-4 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-medium transition-colors">
                    กรองข้อมูล
                </button>
                <a href="{{ route('repairs.index') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-medium transition-colors">
                    ล้างค่า
                </a>
            </div>
        </form>
    </div>

    <!-- Repairs Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3.5">รหัสใบซ่อม</th>
                        <th class="px-4 py-3.5">ลูกค้า</th>
                        <th class="px-4 py-3.5">อุปกรณ์ / อาการเสีย</th>
                        <th class="px-4 py-3.5">ช่างซ่อม</th>
                        <th class="px-4 py-3.5">ความเร่งด่วน</th>
                        <th class="px-4 py-3.5">สถานะ</th>
                        <th class="px-4 py-3.5">วันที่รับเครื่อง</th>
                        <th class="px-5 py-3.5 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($repairs as $repair)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-4 font-semibold text-slate-800 whitespace-nowrap">
                                <a href="{{ route('repairs.show', $repair) }}" class="text-blue-600 hover:underline">
                                    {{ $repair->repair_code }}
                                </a>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="font-medium text-slate-700">{{ $repair->customer->name ?? '-' }}</div>
                                <div class="text-xs text-slate-400">{{ $repair->customer->phone ?? '' }}</div>
                            </td>
                            <td class="px-4 py-4 max-w-xs">
                                <div class="font-medium text-slate-800">{{ $repair->device_type }} {{ $repair->brand }} {{ $repair->model }}</div>
                                <div class="text-xs text-slate-400 truncate">{{ $repair->problem_description }}</div>
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-600 whitespace-nowrap">
                                {{ $repair->technician->name ?? 'ยังไม่ได้มอบหมาย' }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @php
                                    $priorityClasses = [
                                        'urgent' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        'high' => 'bg-orange-50 text-orange-700 border-orange-200',
                                        'normal' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'low' => 'bg-slate-100 text-slate-600 border-slate-200',
                                    ];
                                    $priorityLabels = [
                                        'urgent' => 'ด่วนที่สุด',
                                        'high' => 'ด่วน',
                                        'normal' => 'ปกติ',
                                        'low' => 'ต่ำ',
                                    ];
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-[11px] font-medium border {{ $priorityClasses[$repair->priority] ?? '' }}">
                                    {{ $priorityLabels[$repair->priority] ?? $repair->priority }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $repair->status_badge_class }}">
                                    {{ $repair->status_label }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-500 whitespace-nowrap">
                                {{ $repair->received_at ? $repair->received_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap space-x-2">
                                <a href="{{ route('repairs.show', $repair) }}" class="text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700">
                                    รายละเอียด
                                </a>
                                <a href="{{ route('repairs.edit', $repair) }}" class="text-xs font-semibold px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700">
                                    แก้ไข
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                ไม่พบข้อมูลใบแจ้งซ่อมตามเงื่อนไขที่ค้นหา
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($repairs->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $repairs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
