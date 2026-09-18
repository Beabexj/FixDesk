<header class="h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between shadow-xs flex-shrink-0">
    <div class="flex items-center gap-3">
        <!-- Hamburger Menu Button for Mobile (<992px) -->
        <button class="btn btn-sm btn-light border text-secondary d-lg-none d-inline-flex align-items-center justify-content-center px-2.5 py-1.5 rounded-lg shadow-2xs"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu"
                aria-controls="sidebarMenu"
                aria-label="เมนูหลัก">
            <i class="bi bi-list fs-5 lh-1"></i>
        </button>

        <h1 class="text-base sm:text-lg font-semibold text-slate-800 truncate">
            @yield('title', 'Dashboard')
        </h1>
    </div>

    <div class="flex items-center gap-2 sm:gap-3">
        <!-- Quick Action button -->
        <x-button variant="primary" size="sm" href="{{ route('repairs.create') }}" icon="bi-plus-lg">
            <span class="hidden sm:inline">เปิดใบแจ้งซ่อมใหม่</span>
            <span class="sm:hidden">ใบแจ้งซ่อม</span>
        </x-button>

        <!-- User Profile Pill -->
        @auth
            <div class="hidden md:flex items-center gap-2.5 pl-3 border-l border-slate-200">
                @if(auth()->user()->avatar_url)
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-7 h-7 rounded-full object-cover border border-slate-200 shadow-2xs">
                @else
                    <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-xs">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="flex items-center gap-1.5">
                    <span class="text-xs text-slate-600">สวัสดี, <strong class="text-slate-800">{{ auth()->user()->name }}</strong></span>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold {{ auth()->user()->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                        {{ auth()->user()->role === 'admin' ? 'Admin' : 'ช่างซ่อม' }}
                    </span>
                </div>
            </div>
        @endauth
    </div>
</header>
