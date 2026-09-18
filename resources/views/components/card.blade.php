@props([
    'title' => null,
    'description' => null,
    'noPadding' => false,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden']) }}>
    @if($title || isset($actions))
        <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white">
            <div>
                @if($title)
                    <h3 class="text-base font-bold text-slate-800">{{ $title }}</h3>
                @endif
                @if($description)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $description }}</p>
                @endif
            </div>

            @if(isset($actions))
                <div class="flex items-center gap-2">
                    {{ $actions }}
                </div>
            @endif
        </div>
    @endif

    <div class="{{ $noPadding ? '' : 'p-6' }}">
        {{ $slot }}
    </div>
</div>
