@extends('layouts.app')

@section('title', 'API Documentation')
@section('page-title', 'API Documentation')
@section('page-subtitle', 'Dokumentasi endpoint Fold & Wash API')

@section('content')

<div class="space-y-6">

    <!-- HERO -->

    <div class="bg-gradient-to-r from-primary-500 to-primary-600 rounded-3xl p-8 text-white shadow-lg">

        <h1 class="text-3xl font-display font-700 mb-2">
            Fold & Wash API
        </h1>

        <p class="text-primary-100 text-sm">
            API documentation untuk integrasi website admin dan mobile app customer.
        </p>

        <div class="mt-5 inline-flex items-center gap-2 bg-white/10 px-4 py-2 rounded-xl text-sm font-mono">
            BASE URL:
            <span class="text-white">
                http://172.16.0.65:8000/api
            </span>
        </div>

    </div>

    <!-- TOP SWITCH -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-3 flex items-center gap-3 w-fit">

        <button
            onclick="switchApiTab('web')"
            id="webTabBtn"
            class="api-tab-btn active px-5 py-2.5 rounded-xl text-sm font-semibold transition"
        >
            <i class="fa-solid fa-globe mr-2"></i>
            Web Admin API
        </button>

        <button
            onclick="switchApiTab('mobile')"
            id="mobileTabBtn"
            class="api-tab-btn px-5 py-2.5 rounded-xl text-sm font-semibold transition"
        >
            <i class="fa-solid fa-mobile-screen mr-2"></i>
            Mobile App API
        </button>

    </div>

    <!-- WEB API -->
    <div id="webApiSection">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- AUTH -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-display font-700 text-slate-700">
                        Authentication
                    </h2>
                </div>

                <div class="p-6 space-y-4">

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">
                                POST
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/login
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Login admin untuk akses dashboard.
                        </p>
                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/profile
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Mengambil data profile user login.
                        </p>
                    </div>

                </div>
            </div>

            <!-- CUSTOMER -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-display font-700 text-slate-700">
                        Customer API
                    </h2>
                </div>

                <div class="p-6 space-y-4">

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/customers
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Mengambil semua data pelanggan.
                        </p>
                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">
                                POST
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/customers
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Menambahkan pelanggan baru.
                        </p>
                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 rounded-lg bg-amber-100 text-amber-700 text-xs font-bold">
                                PUT
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/customers/{id}
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Update data pelanggan.
                        </p>
                    </div>

                </div>
            </div>

            <!-- TRANSACTION -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-display font-700 text-slate-700">
                        Transaction API
                    </h2>
                </div>

                <div class="p-6 space-y-4">

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/transactions
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Mengambil seluruh transaksi laundry.
                        </p>
                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">
                                POST
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/transactions
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Membuat transaksi baru.
                        </p>
                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 rounded-lg bg-amber-100 text-amber-700 text-xs font-bold">
                                PUT
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/transactions/{id}/status
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Update status laundry.
                        </p>
                    </div>

                </div>
            </div>

            <!-- REPORT -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-display font-700 text-slate-700">
                        Report API
                    </h2>
                </div>

                <div class="p-6 space-y-4">

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/report-income
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Mengambil laporan pemasukan laundry.
                        </p>
                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/statistics
                            </span>
                        </div>

                        <p class="text-sm text-slate-600">
                            Statistik dashboard admin.
                        </p>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <!-- MOBILE API -->
    <div id="mobileApiSection" class="hidden">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- MOBILE AUTH -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-display font-700 text-slate-700">
                        Mobile Authentication
                    </h2>
                </div>

                <div class="p-6 space-y-4">

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">

                            <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">
                                POST
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/login
                            </span>

                        </div>

                        <p class="text-sm text-slate-600">
                            Login customer di aplikasi mobile.
                        </p>
                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">

                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/profile
                            </span>

                        </div>

                        <p class="text-sm text-slate-600">
                            Mengambil data profile customer.
                        </p>
                    </div>

                </div>
            </div>

            <!-- MOBILE FEATURE -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">

                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-display font-700 text-slate-700">
                        Mobile Features API
                    </h2>
                </div>

                <div class="p-6 space-y-4">

                    <div class="border border-slate-100 rounded-xl p-4">

                        <div class="flex items-center justify-between mb-2">

                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/status-laundry
                            </span>

                        </div>

                        <p class="text-sm text-slate-600">
                            Tracking status laundry customer.
                        </p>

                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">

                        <div class="flex items-center justify-between mb-2">

                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/history
                            </span>

                        </div>

                        <p class="text-sm text-slate-600">
                            Riwayat transaksi laundry customer.
                        </p>

                    </div>

                    <div class="border border-slate-100 rounded-xl p-4">

                        <div class="flex items-center justify-between mb-2">

                            <span class="px-2 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-bold">
                                GET
                            </span>

                            <span class="text-xs font-mono text-slate-400">
                                /api/transactions/{id}
                            </span>

                        </div>

                        <p class="text-sm text-slate-600">
                            Detail transaksi laundry customer.
                        </p>

                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('styles')
<style>

.api-tab-btn {
    background: #f8fafc;
    color: #64748b;
}

.api-tab-btn.active {
    background: linear-gradient(
        135deg,
        #3b82f6,
        #2563eb
    );

    color: white;

    box-shadow:
        0 10px 25px rgba(59,130,246,.25);
}

</style>
@endpush

@push('scripts')
<script>

function switchApiTab(type) {

    const webSection =
        document.getElementById('webApiSection');

    const mobileSection =
        document.getElementById('mobileApiSection');

    const webBtn =
        document.getElementById('webTabBtn');

    const mobileBtn =
        document.getElementById('mobileTabBtn');

    if (type === 'web') {

        webSection.classList.remove('hidden');
        mobileSection.classList.add('hidden');

        webBtn.classList.add('active');
        mobileBtn.classList.remove('active');

    } else {

        mobileSection.classList.remove('hidden');
        webSection.classList.add('hidden');

        mobileBtn.classList.add('active');
        webBtn.classList.remove('active');
    }
}

</script>
@endpush
