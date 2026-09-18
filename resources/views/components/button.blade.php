@props([
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'href' => null,
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:opacity-50 disabled:pointer-events-none cursor-pointer';

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs rounded-lg gap-1.5',
        'md' => 'px-4 py-2 text-sm rounded-xl gap-2',
        'lg' => 'px-5 py-2.5 text-base rounded-xl gap-2.5',
    ];

    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white shadow-sm shadow-blue-500/20 focus:ring-blue-500 border border-transparent',
        'secondary' => 'bg-slate-100 hover:bg-slate-200 active:bg-slate-300 text-slate-700 focus:ring-slate-400 border border-transparent',
        'dark' => 'bg-slate-800 hover:bg-slate-900 active:bg-black text-white shadow-xs focus:ring-slate-700 border border-transparent',
        'danger' => 'bg-rose-600 hover:bg-rose-700 active:bg-rose-800 text-white shadow-xs focus:ring-rose-500 border border-transparent',
        'danger-subtle' => 'text-rose-600 hover:bg-rose-50 active:bg-rose-100 hover:text-rose-700 focus:ring-rose-400 border border-transparent',
        'outline' => 'bg-white hover:bg-slate-50 active:bg-slate-100 text-slate-700 border border-slate-200 shadow-2xs focus:ring-slate-300',
        'outline-primary' => 'bg-blue-50/60 hover:bg-blue-50 active:bg-blue-100 text-blue-600 border border-blue-200 focus:ring-blue-400',
        'success' => 'bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white shadow-xs focus:ring-emerald-500 border border-transparent',
    ];

    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClass = $variants[$variant] ?? $variants['primary'];
    $classes = "{$baseClasses} {$sizeClass} {$variantClass}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="bi {{ $icon }} {{ $size === 'sm' ? 'text-xs' : 'text-sm' }} lh-1"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="bi {{ $icon }} {{ $size === 'sm' ? 'text-xs' : 'text-sm' }} lh-1"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="bi {{ $icon }} {{ $size === 'sm' ? 'text-xs' : 'text-sm' }} lh-1"></i>
        @endif

        {{ $slot }}

        @if($icon && $iconPosition === 'right')
            <i class="bi {{ $icon }} {{ $size === 'sm' ? 'text-xs' : 'text-sm' }} lh-1"></i>
        @endif
    </button>
@endif
