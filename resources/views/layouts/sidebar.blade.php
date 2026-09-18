<aside class="w-64 bg-slate-900 text-slate-200 flex flex-col flex-shrink-0 min-h-screen border-r border-slate-800">
    <!-- Brand -->
    <div class="h-16 flex items-center px-6 border-b border-slate-800/80 gap-3">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white font-bold shadow-md shadow-blue-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
            </svg>
        </div>
        <div>
            <div class="font-bold text-lg text-white tracking-wide leading-none">FixDesk</div>
            <div class="text-xs text-slate-400 mt-0.5">ระบบจัดการงานซ่อม</div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-5 space-y-1.5 overflow-y-auto">
        <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">เมนูหลัก</div>

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            แดชบอร์ด
        </a>

        <a href="{{ route('repairs.index') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('repairs.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            รายการใบแจ้งซ่อม
        </a>

        <a href="{{ route('customers.index') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('customers.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            ข้อมูลลูกค้า
        </a>

        <div class="pt-4 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">ระบบและการจัดการ</div>

        <a href="{{ route('reports.index') }}"
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            รายงานและสถิติ
        </a>

        @if(auth()->user()?->role === 'admin')
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-600/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                ผู้ใช้งานและช่างซ่อม
            </a>
        @endif
    </nav>

    <!-- Bottom user profile & Logout panel -->
    <div class="p-4 border-t border-slate-800/80 bg-slate-950/50">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 overflow-hidden">
                <div class="w-9 h-9 rounded-full bg-blue-600/30 border border-blue-500/30 text-blue-400 flex items-center justify-center font-bold text-xs flex-shrink-0">
                    {{ mb_substr(auth()->user()?->name ?? 'AD', 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-xs font-semibold text-white truncate">{{ auth()->user()?->name ?? 'ผู้ดูแลระบบ' }}</div>
                    <div class="text-[10px] text-slate-400 truncate">
                        @if(auth()->user()?->role === 'admin')
                            <span class="text-purple-300 font-medium">ผู้ดูแลระบบ (Admin)</span>
                        @elseif(auth()->user()?->role === 'technician')
                            <span class="text-blue-300 font-medium">ช่างซ่อม (Technician)</span>
                        @else
                            <span class="text-slate-300">เจ้าหน้าที่</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="ออกจากระบบ"
                        class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
