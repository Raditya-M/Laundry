<header class="bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between sticky top-0 z-10">
    <div class="flex items-center gap-4">
        <!-- Mobile menu button -->
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 text-slate-500">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div>
            <h1 class="font-display font-semibold text-slate-800 text-lg leading-tight">@yield('page-title', 'Dashboard')</h1>
            <p class="text-xs text-slate-400">@yield('page-subtitle', 'Selamat datang di LaundryPOS')</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <div class="hidden md:flex items-center gap-2 text-xs text-slate-400 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
            <i class="fa-regular fa-clock text-primary-400"></i>
            <span id="navClock">--:--</span>
        </div>
        <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center shadow shadow-primary-200 cursor-pointer">
            <i class="fa-solid fa-user text-white text-xs"></i>
        </div>
    </div>
</header>