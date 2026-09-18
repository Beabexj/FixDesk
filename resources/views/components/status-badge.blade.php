@props([
    'status' => 'received',
    'size' => 'sm',
    'showIcon' => true,
])

@php
    $config = [
        'received' => [
            'label' => 'รับเครื่อง',
            'sub' => 'Received',
            'class' => 'bg-slate-100 text-slate-700 border-slate-200',
            'dot' => 'bg-slate-400',
            'icon' => 'bi-inbox',
        ],
        'inspection' => [
            'label' => 'ตรวจสอบ',
            'sub' => 'Inspection',
            'class' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
            'dot' => 'bg-cyan-500',
            'icon' => 'bi-search',
        ],
        'in_progress' => [
            'label' => 'กำลังซ่อม',
            'sub' => 'In Progress',
            'class' => 'bg-blue-50 text-blue-700 border-blue-200',
            'dot' => 'bg-blue-500',
            'icon' => 'bi-tools',
        ],
        'waiting_parts' => [
            'label' => 'รออะไหล่',
            'sub' => 'Waiting Parts',
            'class' => 'bg-amber-50 text-amber-700 border-amber-200',
            'dot' => 'bg-amber-500',
            'icon' => 'bi-hourglass-split',
        ],
        'completed' => [
            'label' => 'ซ่อมเสร็จ',
            'sub' => 'Completed',
            'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'dot' => 'bg-emerald-500',
            'icon' => 'bi-check-circle-fill',
        ],
        'delivered' => [
            'label' => 'ส่งมอบแล้ว',
            'sub' => 'Delivered',
            'class' => 'bg-teal-50 text-teal-700 border-teal-200',
            'dot' => 'bg-teal-500',
            'icon' => 'bi-check2-all',
        ],
        'cancelled' => [
            'label' => 'ยกเลิก',
            'sub' => 'Cancelled',
            'class' => 'bg-rose-50 text-rose-700 border-rose-200',
            'dot' => 'bg-rose-500',
            'icon' => 'bi-x-circle-fill',
        ],
    ];

    $item = $config[$status] ?? [
        'label' => $status,
        'sub' => '',
        'class' => 'bg-slate-100 text-slate-700 border-slate-200',
        'dot' => 'bg-slate-400',
        'icon' => 'bi-info-circle',
    ];

    $sizeClasses = [
        'xs' => 'px-2 py-0.5 text-[11px] gap-1',
        'sm' => 'px-2.5 py-1 text-xs gap-1.5',
        'md' => 'px-3 py-1.5 text-sm gap-2',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['sm'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-full border shadow-2xs {$sizeClass} {$item['class']}"]) }}>
    @if($showIcon)
        <i class="bi {{ $item['icon'] }} text-[0.85em] lh-1"></i>
    @else
        <span class="w-1.5 h-1.5 rounded-full {{ $item['dot'] }}"></span>
    @endif
    <span>{{ $item['label'] }}</span>
</span>
