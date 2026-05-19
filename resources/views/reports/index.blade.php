@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan')
@section('page-subtitle', 'Analitik pendapatan dan transaksi')

@section('content')
<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">
    <div class="card-hover bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-indigo-50 flex items-center justify-center">
                <i class="fa-solid fa-coins text-indigo-500"></i>
            </div>
        </div>
        <p class="text-2xl font-display font-700 text-slate-800" id="rptTotalIncome">—</p>
        <p class="text-xs text-slate-400 mt-1">Pendapatan Hari Ini</p>
    </div>
    <div class="card-hover bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-violet-50 flex items-center justify-center">
                <i class="fa-solid fa-calendar text-violet-500"></i>
            </div>
        </div>
        <p class="text-2xl font-display font-700 text-slate-800" id="rptMonthlyIncome">—</p>
        <p class="text-xs text-slate-400 mt-1">Pendapatan Bulan Ini</p>
    </div>
    <div class="card-hover bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-start justify-between mb-3">
            <div class="w-11 h-11 rounded-xl bg-pink-50 flex items-center justify-center">
                <i class="fa-solid fa-receipt text-pink-500"></i>
            </div>
        </div>
        <p class="text-2xl font-display font-700 text-slate-800" id="rptTotalTrx">—</p>
        <p class="text-xs text-slate-400 mt-1">Total Transaksi</p>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
    <!-- Income Chart -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="mb-4">
            <h3 class="font-display font-700 text-slate-700">Pendapatan Bulanan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Grafik income per bulan</p>
        </div>
        <div id="incomeChartWrap" class="relative h-48">
            <canvas id="incomeChart"></canvas>
            <div id="incomeChartLoading" class="absolute inset-0 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-spinner fa-spin text-xl text-primary-300"></i>
            </div>
        </div>
    </div>

    <!-- Transaction Chart -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="mb-4">
            <h3 class="font-display font-700 text-slate-700">Distribusi Status</h3>
            <p class="text-xs text-slate-400 mt-0.5">Proporsi status transaksi</p>
        </div>
        <div class="relative h-48 flex items-center justify-center">
            <canvas id="statusChart" class="max-h-48"></canvas>
        </div>
        <div id="statusLegend" class="flex flex-wrap gap-2 justify-center mt-4"></div>
    </div>
</div>

<!-- Income Detail Table -->
<div class="mt-5 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="font-display font-700 text-slate-700">Detail Laporan Income</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Periode</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Transaksi</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pendapatan</th>
                </tr>
            </thead>
            <tbody id="incomeTable">
                <tr><td colspan="3" class="px-6 py-10 text-center text-slate-400">
                    <i class="fa-solid fa-spinner fa-spin text-2xl mb-3 block text-primary-300"></i>Memuat...
                </td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    checkAuth();
    loadReports();
});

async function loadReports() {
    try {
        const [statsData, incomeData] = await Promise.all([
            apiFetch('/statistics'),
            apiFetch('/report-income'),
        ]);

        const stats = statsData.data ?? statsData;
        const income = incomeData.data ?? incomeData ?? [];

        console.log('STATS:', stats);
        console.log('INCOME:', income);

        // Summary
        document.getElementById('rptTotalIncome').textContent =
            formatRupiah(stats.today_income ?? 0);

        document.getElementById('rptMonthlyIncome').textContent =
            formatRupiah(stats.monthly_income ?? 0);

        document.getElementById('rptTotalTrx').textContent =
            stats.total_transaction ?? 0;

        // Income Chart
        document.getElementById('incomeChartLoading').style.display = 'none';
        const incomeArr = Array.isArray(income) ? income : Object.values(income);
        const labels = incomeArr.map(r => r.month ?? r.period ?? r.label ?? '—');
        const values = incomeArr.map(r => Number(r.total ?? r.income ?? r.amount ?? 0));

        new Chart(document.getElementById('incomeChart'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: values,
                    backgroundColor: 'rgba(99,102,241,0.15)',
                    borderColor: 'rgba(99,102,241,0.8)',
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'k', font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                }
            }
        });

        // Status Doughnut (using statistics)
        const statusMap = stats.status_counts ?? {};
        const statusLabels = Object.keys(statusMap);
        const statusValues = Object.values(statusMap).map(Number);
        const statusColors = ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981'];

        if (statusLabels.length) {
            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{ data: statusValues, backgroundColor: statusColors.slice(0, statusLabels.length), borderWidth: 0 }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    cutout: '70%'
                }
            });

            document.getElementById('statusLegend').innerHTML = statusLabels.map((l, i) => `
                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                    <span class="w-2.5 h-2.5 rounded-sm inline-block" style="background:${statusColors[i]}"></span>
                    <span class="capitalize">${l}</span>
                    <span class="font-mono font-medium text-slate-700">(${statusValues[i]})</span>
                </div>
            `).join('');
        }

        // Income Table
        if (!incomeArr.length) {
            document.getElementById('incomeTable').innerHTML =
                `<tr><td colspan="3" class="px-6 py-8 text-center text-slate-400">Data tidak tersedia</td></tr>`;
            return;
        }

        document.getElementById('incomeTable').innerHTML = incomeArr.map(r => `
            <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                <td class="px-6 py-3.5 font-medium text-slate-700">${r.month ?? r.period ?? r.label ?? '—'}</td>
                <td class="px-6 py-3.5 text-slate-500 font-mono">${r.total_transactions ?? r.count ?? '—'}</td>
                <td class="px-6 py-3.5 font-mono font-medium text-primary-600">${formatRupiah(r.total ?? r.income ?? r.amount ?? 0)}</td>
            </tr>
        `).join('');

    } catch(e) { showToast(e.message, 'error'); }
}
</script>
@endpush