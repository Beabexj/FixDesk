@extends('layouts.app')

@section('title', 'ใบแจ้งซ่อม ' . $repair->repair_code)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Action Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-slate-800">{{ $repair->repair_code }}</h2>
                <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $repair->status_badge_class }}">
                    {{ $repair->status_label }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">รับเครื่องวันที่: {{ $repair->received_at ? $repair->received_at->format('d/m/Y H:i น.') : '-' }}</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('repairs.index') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-medium transition-colors">
                &larr; กลับหน้ารายการ
            </a>
            <a href="{{ route('repairs.edit', $repair) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-semibold transition-colors shadow-sm">
                แก้ไขใบซ่อม
            </a>
            <button onclick="window.print()" class="px-3 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition-colors">
                พิมพ์ใบรับซ่อม
            </button>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Device & Problem Info (2 Cols) -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
                <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">ข้อมูลอุปกรณ์</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block">ประเภทอุปกรณ์</span>
                        <span class="font-semibold text-slate-800">{{ $repair->device_type }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">ยี่ห้อ / รุ่น</span>
                        <span class="font-semibold text-slate-800">{{ $repair->brand ?? '-' }} {{ $repair->model ?? '' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Serial Number (S/N)</span>
                        <span class="text-slate-700 font-mono">{{ $repair->serial_number ?? 'ไม่ระบุ' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">อุปกรณ์ที่นำมาด้วย</span>
                        <span class="text-slate-700">{{ $repair->accessories ?? 'ไม่มี' }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-100">
                    <span class="text-xs text-slate-400 block mb-1">อาการเสียที่ลูกค้าแจ้ง</span>
                    <div class="p-3 bg-rose-50/60 rounded-xl text-rose-900 text-sm border border-rose-100">
                        {{ $repair->problem_description }}
                    </div>
                </div>

                @if($repair->repair_notes)
                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <span class="text-xs text-slate-400 block mb-1">บันทึกของช่าง / ผลการตรวจซ่อม</span>
                        <div class="p-3 bg-slate-50 rounded-xl text-slate-700 text-sm border border-slate-200">
                            {{ $repair->repair_notes }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Items / Parts & Labor Section -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-800">รายการอะไหล่และค่าบริการ</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-semibold">
                            <tr>
                                <th class="px-5 py-3">รายการ</th>
                                <th class="px-4 py-3">ประเภท</th>
                                <th class="px-4 py-3 text-center">จำนวน</th>
                                <th class="px-4 py-3 text-right">ราคาต่อหน่วย</th>
                                <th class="px-5 py-3 text-right">รวมเงิน</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($repair->items as $item)
                                <tr>
                                    <td class="px-5 py-3 text-slate-800 font-medium">{{ $item->item_name }}</td>
                                    <td class="px-4 py-3 text-xs text-slate-500">
                                        {{ $item->type === 'service' ? 'ค่าบริการ' : 'อะไหล่' }}
                                    </td>
                                    <td class="px-4 py-3 text-center text-slate-700">{{ $item->quantity }}</td>
                                    <td class="px-4 py-3 text-right text-slate-700">฿{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-5 py-3 text-right font-semibold text-slate-800">฿{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-6 text-center text-xs text-slate-400">
                                        ยังไม่มีการเพิ่มรายการอะไหล่หรือค่าบริการ
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer & Cost Summary Sidebar (1 Col) -->
        <div class="space-y-6">
            <!-- Customer Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500">ข้อมูลลูกค้า</h4>
                    <a href="{{ route('customers.show', $repair->customer) }}" class="text-xs text-blue-600 hover:underline">ดูประวัติ</a>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="font-bold text-slate-800">{{ $repair->customer->name }}</div>
                    <div class="text-slate-600 text-xs">เบอร์โทร: {{ $repair->customer->phone }}</div>
                    <div class="text-slate-600 text-xs">LINE: {{ $repair->customer->line_id ?? '-' }}</div>
                    <div class="text-slate-500 text-xs">{{ $repair->customer->address ?? '' }}</div>
                </div>
            </div>

            <!-- Technician Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100 pb-3 mb-3">ช่างผู้รับผิดชอบ</h4>
                @if($repair->technician)
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 font-bold flex items-center justify-center text-sm">
                            {{ mb_substr($repair->technician->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-slate-800">{{ $repair->technician->name }}</div>
                            <div class="text-xs text-slate-400">{{ $repair->technician->phone ?? 'เบอร์โทรภายใน' }}</div>
                        </div>
                    </div>
                @else
                    <p class="text-xs text-slate-400">ยังไม่ได้มอบหมายช่าง</p>
                @endif
            </div>

            <!-- Cost Summary Card -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-5">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100 pb-3 mb-3">สรุปค่าใช้จ่าย</h4>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <span>ราคาประเมินเบื้องต้น:</span>
                        <span>฿{{ number_format($repair->estimated_cost, 2) }}</span>
                    </div>
                    <div class="pt-3 border-t border-slate-100 flex justify-between font-bold text-base text-slate-800">
                        <span>ยอดชำระสุทธิ:</span>
                        <span class="text-emerald-600">฿{{ number_format($repair->total_cost, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
