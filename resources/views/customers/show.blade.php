@extends('layouts.app')

@section('title', 'ข้อมูลลูกค้า - ' . $customer->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-slate-800">{{ $customer->name }}</h2>
                <a href="{{ route('customers.edit', $customer) }}" class="text-xs px-2.5 py-1 bg-amber-50 text-amber-700 rounded-lg hover:bg-amber-100 font-medium">
                    แก้ไขข้อมูล
                </a>
            </div>
            <p class="text-xs text-slate-500 mt-1">ประวัติและข้อมูลการส่งซ่อมของลูกค้า</p>
        </div>
        <a href="{{ route('customers.index') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-800">
            &larr; กลับหน้ารายการลูกค้า
        </a>
    </div>

    <!-- Customer Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">ข้อมูลติดต่อ</span>
            <div class="mt-3 space-y-2 text-sm">
                <div><strong class="text-slate-700">เบอร์โทร:</strong> <span class="text-slate-600">{{ $customer->phone }}</span></div>
                <div><strong class="text-slate-700">LINE ID:</strong> <span class="text-slate-600">{{ $customer->line_id ?? '-' }}</span></div>
                <div><strong class="text-slate-700">อีเมล:</strong> <span class="text-slate-600">{{ $customer->email ?? '-' }}</span></div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs md:col-span-2">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">ที่อยู่และหมายเหตุ</span>
            <div class="mt-3 space-y-2 text-sm">
                <div><strong class="text-slate-700">ที่อยู่:</strong> <span class="text-slate-600">{{ $customer->address ?? '-' }}</span></div>
                <div><strong class="text-slate-700">หมายเหตุ:</strong> <span class="text-slate-600">{{ $customer->notes ?? '-' }}</span></div>
            </div>
        </div>
    </div>

    <!-- Repair History for this customer -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">ประวัติงานซ่อม ({{ $customer->repairs->count() }} รายการ)</h3>
            <a href="{{ route('repairs.create', ['customer_id' => $customer->id]) }}"
               class="text-xs font-semibold px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                + เปิดใบซ่อมใหม่ให้ลูกค้ารายนี้
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-3">รหัสแจ้งซ่อม</th>
                        <th class="px-4 py-3">อุปกรณ์ / อาการ</th>
                        <th class="px-4 py-3">ช่างผู้รับผิดชอบ</th>
                        <th class="px-4 py-3">สถานะ</th>
                        <th class="px-4 py-3">ยอดรวม</th>
                        <th class="px-5 py-3 text-right">การกระทำ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customer->repairs as $repair)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-5 py-3.5 font-medium text-slate-800 whitespace-nowrap">
                                <a href="{{ route('repairs.show', $repair) }}" class="text-blue-600 hover:underline">
                                    {{ $repair->repair_code }}
                                </a>
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="font-medium text-slate-700">{{ $repair->device_type }} {{ $repair->brand }}</div>
                                <div class="text-xs text-slate-400 truncate max-w-xs">{{ $repair->problem_description }}</div>
                            </td>
                            <td class="px-4 py-3.5 text-slate-600 text-xs">
                                {{ $repair->technician->name ?? 'ยังไม่ระบุ' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $repair->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 font-semibold text-slate-800 whitespace-nowrap">
                                ฿{{ number_format($repair->total_cost ?: $repair->estimated_cost, 2) }}
                            </td>
                            <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                <a href="{{ route('repairs.show', $repair) }}" class="text-xs font-medium px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700">
                                    ดูใบซ่อม
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-slate-400 text-xs">
                                ลูกค้ารายนี้ยังไม่มีประวัติการแจ้งซ่อม
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
