<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-white border-r border-slate-100 flex flex-col -translate-x-full lg:translate-x-0 shadow-xl lg:shadow-none">
    <!-- Logo -->
    <div class="px-6 py-5 border-b border-slate-100">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div>
                <p class="font-display font-700 text-slate-800 text-lg leading-none">Fold & Wash Laundry</p>
                <p class="text-xs text-slate-400 font-mono mt-0.5">Admin Panel</p>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        <p class="text-[10px] font-600 text-slate-400 uppercase tracking-widest px-3 py-2 font-display">Menu</p>

        <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 font-medium {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high w-4 text-slate-400 text-sm"></i>
            <span class="text-sm">Dashboard</span>
        </a>
        <a href="{{ route('services') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 font-medium {{ request()->routeIs('services') ? 'active' : '' }}">
            <i class="fa-solid fa-list-check w-4 text-slate-400 text-sm"></i>
            <span class="text-sm">Layanan</span>
        </a>
        <a href="{{ route('customers') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 font-medium {{ request()->routeIs('customers') ? 'active' : '' }}">
            <i class="fa-solid fa-users w-4 text-slate-400 text-sm"></i>
            <span class="text-sm">Pelanggan</span>
        </a>
        <a href="{{ route('transactions') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 font-medium {{ request()->routeIs('transactions') ? 'active' : '' }}">
            <i class="fa-solid fa-receipt w-4 text-slate-400 text-sm"></i>
            <span class="text-sm">Transaksi</span>
        </a>
        <a href="{{ route('reports') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 font-medium {{ request()->routeIs('reports') ? 'active' : '' }}">
            <i class="fa-solid fa-chart-line w-4 text-slate-400 text-sm"></i>
            <span class="text-sm">Laporan</span>
        </a>

        <a href="{{ route('api-docs') }}"
           class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 font-medium {{ request()->routeIs('api-docs') ? 'active' : '' }}">
            <i class="fa-solid fa-code w-4 text-slate-400 text-sm"></i>
            <span class="text-sm">
                API Docs
            </span>
        </a>

        <div class="pt-4">
            <p class="text-[10px] font-600 text-slate-400 uppercase tracking-widest px-3 py-2 font-display">Akun</p>
            <button onclick="doLogout()" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-600 font-medium hover:bg-red-50 hover:text-red-500 group">
                <i class="fa-solid fa-right-from-bracket w-4 text-slate-400 text-sm group-hover:text-red-400"></i>
                <span class="text-sm">Logout</span>
            </button>
        </div>
    </nav>

    <!-- User Info -->
    <div class="px-4 py-4 border-t border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                <i class="fa-solid fa-user text-primary-500 text-xs"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-700 truncate" id="sidebarUserName">Admin</p>
                <p class="text-xs text-slate-400 truncate" id="sidebarUserEmail">admin@gmail.com</p>
            </div>
        </div>
    </div>
</aside>
