<!-- Bootstrap 5.3 Responsive Sidebar: Variant 2 (bg-body-tertiary with offcanvas-lg) -->
<aside id="sidebarMenu"
       class="offcanvas-lg offcanvas-start d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary border-end shadow-xs sticky-lg-top"
       tabindex="-1"
       aria-labelledby="sidebarMenuLabel"
       style="width: 280px; height: 100vh; max-height: 100vh;">
    <!-- Header with Brand & Mobile Close Button -->
    <div class="d-flex align-items-center justify-content-between mb-3 mb-md-0 px-1 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-2 link-body-emphasis text-decoration-none">
            <div class="rounded-3 bg-primary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 38px; height: 38px;">
                <i class="bi bi-wrench-adjustable-circle fs-5"></i>
            </div>
            <div>
                <span class="fs-4 fw-bold text-primary lh-1 tracking-tight" id="sidebarMenuLabel">FixDesk</span>
                <small class="d-block text-body-secondary" style="font-size: 11px;">ระบบจัดการงานซ่อม</small>
            </div>
        </a>
        <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>

    <hr class="my-3 opacity-15 flex-shrink-0">

    <!-- Navigation Menu (nav-pills) -->
    <ul class="nav nav-pills flex-column mb-auto gap-1 overflow-y-auto flex-nowrap py-1">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}"
               class="nav-link d-flex align-items-center gap-2.5 py-2 px-3 fw-medium {{ request()->routeIs('dashboard') ? 'active' : 'link-body-emphasis' }}"
               aria-current="page">
                <i class="bi bi-speedometer2 fs-6"></i>
                แดชบอร์ด
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('repairs.index') }}"
               class="nav-link d-flex align-items-center gap-2.5 py-2 px-3 fw-medium {{ request()->routeIs('repairs.*') ? 'active' : 'link-body-emphasis' }}">
                <i class="bi bi-tools fs-6"></i>
                รายการใบแจ้งซ่อม
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('customers.index') }}"
               class="nav-link d-flex align-items-center gap-2.5 py-2 px-3 fw-medium {{ request()->routeIs('customers.*') ? 'active' : 'link-body-emphasis' }}">
                <i class="bi bi-people-fill fs-6"></i>
                ข้อมูลลูกค้า
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('reports.index') }}"
               class="nav-link d-flex align-items-center gap-2.5 py-2 px-3 fw-medium {{ request()->routeIs('reports.*') ? 'active' : 'link-body-emphasis' }}">
                <i class="bi bi-bar-chart-line-fill fs-6"></i>
                รายงานและสถิติ
            </a>
        </li>

        @if(auth()->user()?->role === 'admin')
            <li class="nav-item">
                <a href="{{ route('users.index') }}"
                   class="nav-link d-flex align-items-center gap-2.5 py-2 px-3 fw-medium {{ request()->routeIs('users.*') ? 'active' : 'link-body-emphasis' }}">
                    <i class="bi bi-person-gear fs-6"></i>
                    ผู้ใช้งานและช่างซ่อม
                </a>
            </li>
        @endif
    </ul>

    <hr class="my-3 opacity-15 flex-shrink-0">

    <!-- Bottom User Dropdown Menu -->
    <div class="dropdown dropup mt-auto flex-shrink-0">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle p-2 rounded-3 hover-bg" data-bs-toggle="dropdown" aria-expanded="false">
            @if(auth()->user()?->avatar_url)
                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="rounded-circle object-fit-cover me-2 border flex-shrink-0 shadow-2xs" style="width: 36px; height: 36px;">
            @else
                <div class="rounded-circle bg-primary-subtle text-primary border border-primary-subtle d-flex align-items-center justify-content-center me-2 fw-bold flex-shrink-0" style="width: 36px; height: 36px; font-size: 13px;">
                    {{ mb_substr(auth()->user()?->name ?? 'U', 0, 2) }}
                </div>
            @endif
            <div class="d-flex flex-column text-start me-auto overflow-hidden pe-2" style="line-height: 1.25;">
                <strong class="text-truncate" style="font-size: 13.5px; max-width: 145px;">{{ auth()->user()?->name ?? 'ผู้ใช้งาน' }}</strong>
                <small class="text-body-secondary text-truncate" style="font-size: 11px;">
                    @if(auth()->user()?->role === 'admin')
                        <span class="text-primary fw-medium">ผู้ดูแลระบบ (Admin)</span>
                    @elseif(auth()->user()?->role === 'technician')
                        <span class="text-success fw-medium">ช่างซ่อม (Technician)</span>
                    @else
                        <span>เจ้าหน้าที่</span>
                    @endif
                </small>
            </div>
        </a>

        <!-- Dropdown Menu -->
        <ul class="dropdown-menu text-small shadow border-0 p-2 mb-2" style="min-width: 220px; border-radius: 12px;">
            <li>
                <div class="px-2 py-1 mb-1">
                    <div class="fw-semibold text-truncate" style="font-size: 13px;">{{ auth()->user()?->name }}</div>
                    <div class="text-body-secondary text-truncate" style="font-size: 11px;">{{ auth()->user()?->email }}</div>
                </div>
            </li>
            @if(auth()->user()?->role === 'admin')
                <li><hr class="dropdown-divider my-1"></li>
                <li>
                    <a class="dropdown-item rounded-2 d-flex align-items-center gap-2 py-1.5" href="{{ route('users.index') }}">
                        <i class="bi bi-person-gear text-secondary"></i>
                        จัดการผู้ใช้งาน
                    </a>
                </li>
            @endif
            <li><hr class="dropdown-divider my-1"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item rounded-2 text-danger d-flex align-items-center gap-2 py-1.5">
                        <i class="bi bi-box-arrow-right"></i>
                        ออกจากระบบ
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
