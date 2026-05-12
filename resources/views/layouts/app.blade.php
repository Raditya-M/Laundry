<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LaundryPOS Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        primary: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',300:'#93c5fd',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' },
                        slate: { 850:'#0f1729' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(59,130,246,0.15); color: #60a5fa; border-left: 3px solid #3b82f6; }
        .sidebar-link { border-left: 3px solid transparent; }
        .toast { animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.7s forwards; }
        @keyframes slideIn { from { transform: translateX(100%); opacity:0; } to { transform: translateX(0); opacity:1; } }
        @keyframes fadeOut { from { opacity:1; } to { opacity:0; } }
        .modal-overlay { animation: fadeInOverlay 0.2s ease; }
        @keyframes fadeInOverlay { from { opacity:0; } to { opacity:1; } }
        .modal-box { animation: slideUp 0.25s ease; }
        @keyframes slideUp { from { transform:translateY(20px); opacity:0; } to { transform:translateY(0); opacity:1; } }
        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-track { background:#1e293b; }
        ::-webkit-scrollbar-thumb { background:#334155; border-radius:99px; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-950 text-slate-200 min-h-screen flex">

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-slate-900 border-r border-slate-800 flex flex-col z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <!-- Logo -->
        <div class="px-6 py-5 border-b border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/50">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <p class="font-bold text-white text-sm leading-none">LaundryPOS</p>
                    <p class="text-xs text-slate-500 mt-0.5">Admin Panel</p>
                </div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
            <p class="text-xs font-semibold text-slate-600 uppercase tracking-wider px-3 mb-2">Menu Utama</p>
            <a href="/dashboard" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 font-medium {{ request()->is('dashboard') ? 'active' : '' }}">
                <svg class="w-4.5 h-4.5 w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v0"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/></svg>
                Dashboard
            </a>
            <a href="/services" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 font-medium {{ request()->is('services*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Layanan
            </a>
            <a href="/customers" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 font-medium {{ request()->is('customers*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pelanggan
            </a>
            <a href="/transactions" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 font-medium {{ request()->is('transactions*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Transaksi
            </a>
            <a href="/reports" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 font-medium {{ request()->is('reports*') ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Laporan
            </a>

            <div class="pt-4 mt-4 border-t border-slate-800">
                <p class="text-xs font-semibold text-slate-600 uppercase tracking-wider px-3 mb-2">Akun</p>
                <button onclick="handleLogout()" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-slate-400 font-medium hover:text-red-400 hover:bg-red-500/10 hover:border-l-red-500">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </div>
        </nav>

        <!-- User Info -->
        <div class="px-4 py-4 border-t border-slate-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold text-white" id="user-avatar">A</div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate" id="user-name">Admin</p>
                    <p class="text-xs text-slate-500 truncate" id="user-email">admin@gmail.com</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-h-screen lg:ml-64">
        <!-- Topbar -->
        <header class="sticky top-0 z-30 bg-slate-900/80 backdrop-blur border-b border-slate-800 px-4 lg:px-6 py-3 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h1 class="text-base font-bold text-white">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-xs text-slate-500 hidden sm:block">@yield('page-subtitle', 'Selamat datang kembali')</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="text-right hidden sm:block">
                    <p class="text-xs text-slate-500" id="current-date"></p>
                </div>
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-xs font-bold text-white" id="nav-avatar">A</div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-6">
            @yield('content')
        </main>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[100] space-y-2 pointer-events-none"></div>

    <script>
        const API_BASE = 'http://172.16.0.101:8000/api';

        // Auth check
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('auth_token');
            if (!token) { window.location.href = '/'; return; }
            const userData = JSON.parse(localStorage.getItem('user_data') || '{}');
            if (userData.name) {
                document.getElementById('user-name').textContent = userData.name;
                document.getElementById('user-email').textContent = userData.email || '';
                const initial = userData.name.charAt(0).toUpperCase();
                document.getElementById('user-avatar').textContent = initial;
                document.getElementById('nav-avatar').textContent = initial;
            }
            const now = new Date();
            const dateEl = document.getElementById('current-date');
            if (dateEl) dateEl.textContent = now.toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
        });

        function getToken() { return localStorage.getItem('auth_token'); }

        function apiHeaders() {
            return { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + getToken(), 'Accept': 'application/json' };
        }

        async function apiGet(endpoint) {
            const res = await fetch(API_BASE + endpoint, { headers: apiHeaders() });
            if (res.status === 401) { localStorage.clear(); window.location.href = '/'; return null; }
            return await res.json();
        }

        async function apiPost(endpoint, data) {
            const res = await fetch(API_BASE + endpoint, { method:'POST', headers: apiHeaders(), body: JSON.stringify(data) });
            return { status: res.status, data: await res.json() };
        }

        async function apiPut(endpoint, data) {
            const res = await fetch(API_BASE + endpoint, { method:'PUT', headers: apiHeaders(), body: JSON.stringify(data) });
            return { status: res.status, data: await res.json() };
        }

        async function apiDelete(endpoint) {
            const res = await fetch(API_BASE + endpoint, { method:'DELETE', headers: apiHeaders() });
            return { status: res.status, data: res.status !== 204 ? await res.json() : {} };
        }

        async function handleLogout() {
            try { await apiPost('/logout', {}); } catch(e) {}
            localStorage.clear();
            window.location.href = '/';
        }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const colors = { success: 'bg-emerald-500', error: 'bg-red-500', warning: 'bg-amber-500', info: 'bg-blue-500' };
            const icons = {
                success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
                error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
                warning: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
                info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
            };
            const toast = document.createElement('div');
            toast.className = `toast pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl shadow-2xl text-white text-sm font-medium min-w-[260px] max-w-xs ${colors[type]}`;
            toast.innerHTML = `<svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><${icons[type]}</svg><span>${message}</span>`;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 3200);
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', minimumFractionDigits:0 }).format(amount);
        }

        function formatDate(dateStr) {
            if (!dateStr) return '-';
            return new Date(dateStr).toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
        }
    </script>
    @stack('scripts')
</body>
</html>
