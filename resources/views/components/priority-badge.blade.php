@props([
    'priority' => 'normal',
    'size' => 'sm',
])

@php
    $config = [
        'urgent' => [
            'label' => 'ด่วนที่สุด',
            'class' => 'bg-rose-50 text-rose-700 border-rose-200',
            'dot' => 'bg-rose-500',
        ],
        'high' => [
            'label' => 'ด่วน',
            'class' => 'bg-amber-50 text-amber-700 border-amber-200',
            'dot' => 'bg-amber-500',
        ],
        'normal' => [
            'label' => 'ปกติ',
            'class' => 'bg-blue-50 text-blue-700 border-blue-200',
            'dot' => 'bg-blue-500',
        ],
        'low' => [
            'label' => 'ต่ำ',
            'class' => 'bg-slate-100 text-slate-600 border-slate-200',
            'dot' => 'bg-slate-400',
        ],
    ];

    $item = $config[$priority] ?? [
        'label' => $priority,
        'class' => 'bg-slate-100 text-slate-600 border-slate-200',
        'dot' => 'bg-slate-400',
    ];

    $sizeClasses = [
        'xs' => 'px-2 py-0.5 text-[11px] gap-1',
        'sm' => 'px-2 py-0.5 text-xs gap-1.5',
        'md' => 'px-2.5 py-1 text-sm gap-2',
    ];

    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['sm'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center font-medium rounded-full border shadow-2xs {$sizeClass} {$item['class']}"]) }}>
    <span class="w-1.5 h-1.5 rounded-full {{ $item['dot'] }}"></span>
    <span>{{ $item['label'] }}</span>
</span>
