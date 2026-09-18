@extends('layouts.app')

@section('title', 'จัดการข้อมูลลูกค้า')

@section('content')
<div class="space-y-6">
    <!-- Header & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">รายชื่อลูกค้า</h2>
            <p class="text-xs text-slate-500 mt-1">ค้นหาและจัดการประวัติข้อมูลลูกค้าทั้งหมด</p>
        </div>

        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('customers.index') }}" class="flex items-center">
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="ค้นหาชื่อ, เบอร์โทร..."
                           class="w-56 sm:w-72 pl-9 pr-4 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </form>

            <x-button variant="primary" icon="bi-person-plus-fill" href="{{ route('customers.create') }}">
                เพิ่มลูกค้าใหม่
            </x-button>
        </div>
    </div>

    <!-- Customer Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs text-slate-500 uppercase font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3.5">ชื่อ-นามสกุล</th>
                        <th class="px-6 py-3.5">เบอร์โทรศัพท์</th>
                        <th class="px-6 py-3.5">LINE ID / อีเมล</th>
                        <th class="px-6 py-3.5">จำนวนงานซ่อม</th>
                        <th class="px-6 py-3.5 text-right">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">
                                <a href="{{ route('customers.show', $customer) }}" class="text-blue-600 hover:underline">
                                    {{ $customer->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                {{ $customer->phone }}
                            </td>
                            <td class="px-6 py-4 text-slate-600 whitespace-nowrap">
                                <div>{{ $customer->line_id ? 'Line: ' . $customer->line_id : '-' }}</div>
                                <div class="text-xs text-slate-400">{{ $customer->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">
                                    {{ $customer->repairs_count }} รายการ
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap space-x-1.5">
                                <x-button variant="outline" size="sm" href="{{ route('customers.show', $customer) }}">
                                    ดูข้อมูล
                                </x-button>
                                <x-button variant="secondary" size="sm" href="{{ route('customers.edit', $customer) }}">
                                    แก้ไข
                                </x-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                ไม่พบข้อมูลลูกค้าในระบบ
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
