<header class="h-16 bg-white border-b border-slate-200 px-6 flex items-center justify-between shadow-xs">
    <div class="flex items-center gap-4">
        <h1 class="text-lg font-semibold text-slate-800">
            @yield('title', 'Dashboard')
        </h1>
    </div>

    <div class="flex items-center gap-3">
        <!-- Quick Action button -->
        <a href="{{ route('repairs.create') }}"
           class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors shadow-sm shadow-blue-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            เปิดใบแจ้งซ่อมใหม่
        </a>

        <!-- Status pill -->
        <div class="hidden sm:flex items-center gap-2 pl-3 border-l border-slate-200 text-xs text-slate-500">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            ระบบออนไลน์
        </div>
    </div>
</header>
