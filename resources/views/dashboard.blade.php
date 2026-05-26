@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview performa laundry hari ini')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
    <div class="card-hover bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center">
                <i class="fa-solid fa-wallet text-indigo-500"></i>
            </div>
        </div>
        <p class="text-2xl font-display font-700 text-slate-800" id="statTotalIncome">—</p>
        <p class="text-xs text-slate-400 mt-1 font-medium">Pendapatan Hari Ini</p>
    </div>

    <div class="card-hover bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-violet-50 flex items-center justify-center">
                <i class="fa-solid fa-calendar-check text-violet-500"></i>
            </div>
        </div>
        <p class="text-2xl font-display font-700 text-slate-800" id="statMonthlyIncome">—</p>
        <p class="text-xs text-slate-400 mt-1 font-medium">Pendapatan Bulanan</p>
    </div>

    <div class="card-hover bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-pink-50 flex items-center justify-center">
                <i class="fa-solid fa-receipt text-pink-500"></i>
            </div>
        </div>
        <p class="text-2xl font-display font-700 text-slate-800" id="statTotalTrx">—</p>
        <p class="text-xs text-slate-400 mt-1 font-medium">Total Transaksi</p>
    </div>

    <div class="card-hover bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-start justify-between mb-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center">
                <i class="fa-solid fa-hourglass-half text-amber-500"></i>
            </div>
        </div>
        <p class="text-2xl font-display font-700 text-slate-800" id="statPending">—</p>
        <p class="text-xs text-slate-400 mt-1 font-medium">Transaksi Aktif</p>
    </div>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-display font-700 text-slate-700">Transaksi Terbaru</h2>
            <p class="text-xs text-slate-400 mt-0.5">10 transaksi terakhir</p>
        </div>
        <a href="{{ route('transactions') }}" class="text-xs text-primary-500 hover:text-primary-700 font-medium flex items-center gap-1">
            Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Layanan</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Berat/Jumlah</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody id="dashboardTrxTable">
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-3 block text-primary-300"></i>
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    checkAuth();
    loadStats();
    loadRecentTransactions();
});

async function loadStats() {
    try {
        const stats = await apiFetch('/statistics');

        document.getElementById('statTotalIncome').textContent =
            formatRupiah(stats.today_income ?? 0);

        document.getElementById('statMonthlyIncome').textContent =
            formatRupiah(stats.monthly_income ?? 0);

        document.getElementById('statTotalTrx').textContent =
            stats.total_transaction ?? 0;

        document.getElementById('statPending').textContent =
            stats.total_transaction ?? 0;

    } catch(e) {
        console.error(e);
    }
}

async function loadRecentTransactions() {
    try {
        const response = await apiFetch('/transactions');

        console.log(response);

        const trxs = response.data?.data ?? [];
        const tbody = document.getElementById('dashboardTrxTable');

        if (!trxs.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-400">
                        Belum ada transaksi
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = trxs.slice(0, 10).map(t => `
            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-3.5">
                    <p class="font-medium text-slate-700">
                        ${t.customer?.user?.username ?? '—'}
                    </p>
                </td>

                <td class="px-6 py-3.5 text-slate-500">
                    ${t.service?.service_name ?? '—'}
                </td>

                <td class="px-6 py-3.5 text-slate-500 font-mono">
                    ${formatWeight(t.weight, t.service?.unit)}
                </td>

                <td class="px-6 py-3.5 font-mono font-medium text-slate-700">
                    ${formatRupiah(t.total_price ?? 0)}
                </td>

                <td class="px-6 py-3.5">
                    ${statusBadge(t.status)}
                </td>

                <td class="px-6 py-3.5 text-slate-400 text-xs">
                    ${formatDate(t.created_at)}
                </td>
            </tr>
        `).join('');

    } catch(e) {
        console.error(e);
    }
}
</script>
@endpush
