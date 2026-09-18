@extends('layouts.app')

@section('title', 'รายงานและสถิติการซ่อม')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">รายงานและสถิติภาพรวม</h2>
            <p class="text-xs text-slate-500 mt-1">สรุปข้อมูลผลการดำเนินงาน ยอดรายได้ และสถิติงานซ่อม</p>
        </div>
        <button onclick="window.print()" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold">
            พิมพ์รายงานสรุป
        </button>
    </div>

    <!-- Revenue Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-6 rounded-2xl shadow-sm">
            <span class="text-xs uppercase font-semibold text-blue-100 tracking-wider">รายได้รวมจากงานซ่อมที่สำเร็จ (Total Revenue)</span>
            <div class="text-3xl font-extrabold mt-2">฿{{ number_format($totalIncome, 2) }}</div>
            <p class="text-xs text-blue-100 mt-2">คำนวณจากงานซ่อมสถานะ 'ซ่อมเสร็จแล้ว' และเก็บเงินเรียบร้อย</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs uppercase font-semibold text-slate-400 tracking-wider">มูลค่างานที่อยู่ระหว่างดำเนินการ (Estimated Pipeline)</span>
            <div class="text-3xl font-extrabold text-amber-600 mt-2">฿{{ number_format($estimatedPending, 2) }}</div>
            <p class="text-xs text-slate-400 mt-2">ราคาประเมินรวมของงานที่รอดำเนินการ, กำลังซ่อม, และรออะไหล่</p>
        </div>
    </div>

    <!-- Status & Device Types Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Status Breakdown -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <h3 class="font-bold text-slate-800 text-base mb-4">สัดส่วนสถานะงานซ่อม</h3>
            <div class="space-y-3">
                @php
                    $statusMap = [
                        'pending' => ['name' => 'รอดำเนินการ (Pending)', 'color' => 'bg-amber-500'],
                        'in_progress' => ['name' => 'กำลังซ่อม (In Progress)', 'color' => 'bg-blue-500'],
                        'waiting_parts' => ['name' => 'รออะไหล่ (Waiting Parts)', 'color' => 'bg-purple-500'],
                        'completed' => ['name' => 'ซ่อมเสร็จสิ้น (Completed)', 'color' => 'bg-emerald-500'],
                        'delivered' => ['name' => 'ส่งมอบแล้ว (Delivered)', 'color' => 'bg-slate-500'],
                        'cancelled' => ['name' => 'ยกเลิก (Cancelled)', 'color' => 'bg-rose-500'],
                    ];
                    $totalAll = array_sum($statusCounts) ?: 1;
                @endphp

                @foreach($statusMap as $key => $meta)
                    @php
                        $count = $statusCounts[$key] ?? 0;
                        $pct = round(($count / $totalAll) * 100);
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs font-semibold text-slate-700 mb-1">
                            <span>{{ $meta['name'] }}</span>
                            <span>{{ $count }} รายการ ({{ $pct }}%)</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="{{ $meta['color'] }} h-2 rounded-full" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Devices Breakdown -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <h3 class="font-bold text-slate-800 text-base mb-4">ประเภทอุปกรณ์ที่ลูกค้านำมาซ่อมบ่อย</h3>
            <div class="divide-y divide-slate-100">
                @forelse($deviceCounts as $item)
                    <div class="py-3 flex items-center justify-between first:pt-0 last:pb-0">
                        <span class="text-sm font-medium text-slate-700">{{ $item->device_type }}</span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                            {{ $item->count }} เครื่อง
                        </span>
                    </div>
                @empty
                    <div class="text-center py-6 text-xs text-slate-400">ยังไม่มีข้อมูล</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Completed Repairs Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">รายการซ่อมเสร็จสิ้นล่าสุด</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3">รหัสใบซ่อม</th>
                        <th class="px-4 py-3">ลูกค้า</th>
                        <th class="px-4 py-3">อุปกรณ์</th>
                        <th class="px-4 py-3">ช่างผู้ซ่อม</th>
                        <th class="px-4 py-3 text-right">ยอดเงินรวม</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($completedRepairs as $item)
                        <tr>
                            <td class="px-5 py-3 font-semibold text-blue-600">
                                <a href="{{ route('repairs.show', $item) }}" class="hover:underline">
                                    {{ $item->repair_code }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->customer->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $item->device_type }} {{ $item->brand }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $item->technician->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-right font-bold text-emerald-600">
                                ฿{{ number_format($item->total_cost, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-xs text-slate-400">ยังไม่มีรายการซ่อมที่เสร็จสิ้น</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
