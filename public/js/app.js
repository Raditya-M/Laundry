// ============================================================
// LaundryPOS — Global JS Utilities
// ============================================================

const API_BASE = 'http://172.16.0.53:8000/api';

// ── Auth Guards ──────────────────────────────────────────────
function checkAuth() {
    const token = localStorage.getItem('laundry_token');
    if (!token) {
        window.location.href = '/';
        return false;
    }
    // Populate user info in sidebar
    try {
        const user = JSON.parse(localStorage.getItem('laundry_user') || '{}');
        const nameEl = document.getElementById('sidebarUserName');
        const emailEl = document.getElementById('sidebarUserEmail');
        if (nameEl && user.name) nameEl.textContent = user.name;
        if (emailEl && user.email) emailEl.textContent = user.email;
    } catch(e) {}
    return true;
}

// ── API Fetch Wrapper ────────────────────────────────────────
async function apiFetch(path, method = 'GET', body = null) {
    const token = localStorage.getItem('laundry_token');
    const opts = {
        method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(token ? { 'Authorization': `Bearer ${token}` } : {})
        }
    };
    if (body && method !== 'GET') opts.body = JSON.stringify(body);

    const res = await fetch(`${API_BASE}${path}`, opts);

    if (res.status === 401) {
        localStorage.removeItem('laundry_token');
        localStorage.removeItem('laundry_user');
        window.location.href = '/';
        throw new Error('Sesi berakhir, silakan login kembali');
    }

    const data = await res.json();
    if (!res.ok) throw new Error(data.message || `Error ${res.status}`);
    return data;
}

// ── Logout ───────────────────────────────────────────────────
async function doLogout() {
    try {
        await apiFetch('/logout', 'POST');
    } catch(e) {}
    localStorage.removeItem('laundry_token');
    localStorage.removeItem('laundry_user');
    window.location.href = '/';
}

// ── Toast Notifications ──────────────────────────────────────
function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const colors = {
        success: 'bg-emerald-500',
        error:   'bg-red-500',
        warning: 'bg-amber-500',
        info:    'bg-indigo-500',
    };
    const icons = {
        success: 'fa-circle-check',
        error:   'fa-circle-xmark',
        warning: 'fa-triangle-exclamation',
        info:    'fa-circle-info',
    };

    const id = 'toast_' + Date.now();
    const el = document.createElement('div');
    el.id = id;
    el.className = `toast-enter pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl text-white text-sm shadow-lg max-w-sm ${colors[type] || colors.info}`;
    el.innerHTML = `
        <i class="fa-solid ${icons[type] || icons.info} flex-shrink-0"></i>
        <span class="flex-1">${message}</span>
        <button onclick="removeToast('${id}')" class="text-white/70 hover:text-white ml-1 flex-shrink-0">
            <i class="fa-solid fa-times text-xs"></i>
        </button>
    `;
    container.appendChild(el);

    setTimeout(() => removeToast(id), 4000);
}

function removeToast(id) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.remove('toast-enter');
    el.classList.add('toast-exit');
    setTimeout(() => el.remove(), 350);
}

// ── Helpers ──────────────────────────────────────────────────
function formatRupiah(amount) {
    const num = Number(amount) || 0;
    return 'Rp ' + num.toLocaleString('id-ID');
}

function formatWeight(weight, unit) {
    if (weight == null) return '—';
    const num = Number(weight);
    const formatted = (unit === 'kg') ? num.toFixed(2) : Math.round(num);
    return `${formatted} ${unit ?? 'kg'}`;
}

function formatDate(dateStr) {
    if (!dateStr) return '—';
    return new Date(dateStr).toLocaleDateString('id-ID', {
        day: '2-digit', month: 'short', year: 'numeric'
    });
}

function statusBadge(status) {
    const map = {
        'antrian':      'bg-slate-100 text-slate-600',
        'dicuci':       'bg-blue-100 text-blue-600',
        'disetrika':    'bg-violet-100 text-violet-600',
        'siap diambil': 'bg-amber-100 text-amber-700',
        'diambil':      'bg-emerald-100 text-emerald-700',
    };
    const cls = map[status] ?? 'bg-slate-100 text-slate-500';
    return `<span class="badge ${cls} capitalize">${status ?? '—'}</span>`;
}

// ── Sidebar Toggle (mobile) ───────────────────────────────────
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('mobileOverlay');
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
}

function closeSidebar() {
    document.getElementById('sidebar')?.classList.add('-translate-x-full');
    document.getElementById('mobileOverlay')?.classList.add('hidden');
}

// ── Live Clock ────────────────────────────────────────────────
function updateClock() {
    const el = document.getElementById('navClock');
    if (!el) return;
    const now = new Date();
    el.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
}
setInterval(updateClock, 1000);
updateClock();

// ── Tailwind fontFamily injection fix for display ─────────────
document.querySelectorAll('.font-display').forEach(el => {
    el.style.fontFamily = "'Syne', sans-serif";
});