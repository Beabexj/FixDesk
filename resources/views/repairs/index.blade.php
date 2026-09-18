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

        <x-button variant="primary" icon="bi-plus-lg" href="{{ route('repairs.create') }}">
            เปิดใบแจ้งซ่อมใหม่
        </x-button>
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
                <x-button variant="dark" type="submit" icon="bi-funnel" class="flex-1">
                    กรองข้อมูล
                </x-button>
                <x-button variant="secondary" href="{{ route('repairs.index') }}">
                    ล้างค่า
                </x-button>
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
                                <x-priority-badge :priority="$repair->priority" />
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <x-status-badge :status="$repair->status" />
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-500 whitespace-nowrap">
                                {{ $repair->received_at ? $repair->received_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-5 py-4 text-right whitespace-nowrap space-x-1.5">
                                <x-button variant="outline" size="sm" href="{{ route('repairs.show', $repair) }}">
                                    รายละเอียด
                                </x-button>
                                <x-button variant="secondary" size="sm" href="{{ route('repairs.edit', $repair) }}">
                                    แก้ไข
                                </x-button>
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
