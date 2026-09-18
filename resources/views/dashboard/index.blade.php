@extends('layouts.app')

@section('title', 'ภาพรวมระบบ (Dashboard)')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Total Repairs -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">งานทั้งหมด</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_repairs']) }}</h3>
                <span class="text-xs text-blue-600 font-medium">ทุกรายการ</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
        </div>

        <!-- Received (รับเครื่อง) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">รับเครื่อง</p>
                <h3 class="text-2xl font-bold text-slate-700 mt-1">{{ number_format($stats['received_repairs']) }}</h3>
                <span class="text-xs text-slate-500 font-medium">รอช่างตรวจเช็ค</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            </div>
        </div>

        <!-- Inspection (ตรวจสอบ) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">รอตรวจสอบ</p>
                <h3 class="text-2xl font-bold text-cyan-600 mt-1">{{ number_format($stats['inspection_repairs']) }}</h3>
                <span class="text-xs text-cyan-600 font-medium">กำลังเช็คอาการ</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- In Progress & Waiting Parts (กำลังซ่อม) -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">กำลังซ่อม</p>
                <h3 class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($stats['in_progress_repairs']) }}</h3>
                <span class="text-xs text-blue-600 font-medium">รวมรออะไหล่</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
        </div>

        <!-- Completed / Delivered -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">ซ่อมเสร็จ / ส่งมอบ</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($stats['completed_repairs']) }}</h3>
                <span class="text-xs text-emerald-600 font-medium">฿{{ number_format($stats['total_revenue'], 2) }}</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Main Section: Recent Repairs & Customers -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        <!-- Recent Repairs Table (9 of 12 Cols on XL = 75% width) -->
        <div class="xl:col-span-9 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-800 text-base">งานซ่อมล่าสุด</h2>
                    <p class="text-xs text-slate-400 mt-0.5">รายการซ่อมที่มีการบันทึกและอัปเดตสถานะล่าสุด</p>
                </div>
                <a href="{{ route('repairs.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    ดูทั้งหมด
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50/80 text-xs text-slate-500 uppercase font-semibold border-b border-slate-100">
                        <tr>
                            <th class="px-4 py-3">รหัสงาน</th>
                            <th class="px-3.5 py-3">ลูกค้า</th>
                            <th class="px-3.5 py-3">อุปกรณ์ / รุ่น</th>
                            <th class="px-3.5 py-3">สถานะ</th>
                            <th class="px-4 py-3 text-right">การกระทำ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recent_repairs as $repair)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-3 font-bold text-slate-800 whitespace-nowrap">
                                    <a href="{{ route('repairs.show', $repair) }}" class="text-blue-600 hover:underline">
                                        {{ $repair->repair_code }}
                                    </a>
                                </td>
                                <td class="px-3.5 py-3 whitespace-nowrap">
                                    <div class="font-medium text-slate-700 truncate max-w-[150px] 2xl:max-w-[200px]" title="{{ $repair->customer->name ?? '-' }}">{{ $repair->customer->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $repair->customer->phone ?? '' }}</div>
                                </td>
                                <td class="px-3.5 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($repair->device_image_url)
                                            <img src="{{ $repair->device_image_url }}" alt="รูปเครื่อง" class="w-8 h-8 rounded-lg object-cover border border-slate-200 flex-shrink-0 shadow-2xs">
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-medium text-slate-700 truncate max-w-[200px] 2xl:max-w-[300px]" title="{{ $repair->device_type }} {{ $repair->brand }} {{ $repair->model }}">
                                                {{ $repair->device_type }} {{ $repair->brand }} {{ $repair->model }}
                                            </div>
                                            <div class="text-xs text-slate-400 truncate max-w-[200px] 2xl:max-w-[300px]" title="{{ $repair->problem_description }}">
                                                {{ $repair->problem_description }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3.5 py-3 whitespace-nowrap">
                                    <x-status-badge :status="$repair->status" size="sm" />
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <x-button variant="outline" size="sm" href="{{ route('repairs.show', $repair) }}">
                                        ดูข้อมูล
                                    </x-button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-xs">ยังไม่มีรายการแจ้งซ่อม</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Customers (3 of 12 Cols on XL = 25% width) -->
        <div class="xl:col-span-3 bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden flex flex-col">
            <div class="p-4 sm:p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-800 text-base">ลูกค้าล่าสุด</h2>
                    <p class="text-xs text-slate-400 mt-0.5">รายชื่อลูกค้าที่เพิ่มล่าสุด</p>
                </div>
                <a href="{{ route('customers.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    ดูทั้งหมด
                </a>
            </div>

            <div class="p-4 sm:p-5 divide-y divide-slate-100 space-y-3.5 flex-1">
                @forelse($recent_customers as $customer)
                    <div class="pt-3 first:pt-0 flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 font-bold flex items-center justify-center text-xs flex-shrink-0">
                                {{ mb_substr($customer->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-semibold text-slate-800 truncate" title="{{ $customer->name }}">{{ $customer->name }}</h4>
                                <p class="text-xs text-slate-400 truncate">{{ $customer->phone }}</p>
                            </div>
                        </div>
                        <a href="{{ route('customers.show', $customer) }}" class="text-xs font-medium text-slate-500 hover:text-blue-600 flex-shrink-0 px-2 py-1 rounded-lg hover:bg-slate-100 transition-colors">
                            ดูข้อมูล
                        </a>
                    </div>
                @empty
                    <div class="py-6 text-center text-slate-400 text-xs">ยังไม่มีข้อมูลลูกค้า</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
