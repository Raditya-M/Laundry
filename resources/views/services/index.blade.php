@extends('layouts.app')

@section('title', 'Layanan')
@section('page-title', 'Layanan')
@section('page-subtitle', 'Kelola layanan laundry')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <!-- Header -->
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-display font-700 text-slate-700">Daftar Layanan</h2>
            <p class="text-xs text-slate-400 mt-0.5" id="serviceCount">—</p>
        </div>
        <button onclick="openModal('add')" class="flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors shadow shadow-primary-200">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Layanan
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Layanan</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Harga</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Satuan</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="serviceTable">
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-3 block text-primary-300"></i>Memuat...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="serviceModal" class="fixed inset-0 z-50 hidden modal-overlay bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md" style="animation: fadeUp 0.3s ease">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-display font-700 text-slate-700" id="modalTitle">Tambah Layanan</h3>
            <button onclick="closeModal()" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <input type="hidden" id="serviceId">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Nama Layanan</label>
                <input type="text" id="serviceName" placeholder="Contoh: Kiloan/Satuan"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-50 transition">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Harga (Rp)</label>
                <input type="number" id="servicePrice" placeholder="5000"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-50 transition">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Satuan</label>
                <select id="serviceUnit"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-50 transition">
                    <option value="kg">kg</option>
                    <option value="pcs">pcs</option>
                </select>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="closeModal()" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition">Batal</button>
            <button onclick="saveService()" id="saveServiceBtn" class="flex-1 py-2.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium transition shadow shadow-primary-200">Simpan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let editingId = null;

document.addEventListener('DOMContentLoaded', () => {
    checkAuth();
    loadServices();
});

async function loadServices() {
    try {
        const data = await apiFetch('/services');
        const services = data.data.data ?? [];
        document.getElementById('serviceCount').textContent = `${services.length} layanan tersedia`;

        if (!services.length) {
            document.getElementById('serviceTable').innerHTML =
                `<tr><td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada layanan</td></tr>`;
            return;
        }

        document.getElementById('serviceTable').innerHTML = services.map((s, i) => `
            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-3.5 text-slate-400 text-xs font-mono">${i+1}</td>
                <td class="px-6 py-3.5 font-medium text-slate-700">${s.service_name}</td>
                <td class="px-6 py-3.5 font-mono text-primary-600 font-medium">${formatRupiah(s.price)}</td>
                <td class="px-6 py-3.5"><span class="badge bg-slate-100 text-slate-600">${s.unit}</span></td>
                <td class="px-6 py-3.5 text-right">
                    <button onclick="openModal('edit', ${JSON.stringify(s).replace(/"/g,'&quot;')})"
                        class="text-xs text-primary-500 hover:text-primary-700 font-medium px-3 py-1.5 rounded-lg hover:bg-primary-50 transition mr-1">
                        <i class="fa-solid fa-pen"></i> Edit
                    </button>
                    <button onclick="deleteService(${s.id})"
                        class="text-xs text-red-400 hover:text-red-600 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
        `).join('');
    } catch(e) {
        console.error(e);
        showToast(e.message || 'Terjadi error', 'error');
    }
}

function openModal(mode, data = null) {
    editingId = null;
    document.getElementById('serviceId').value = '';
    document.getElementById('serviceName').value = '';
    document.getElementById('servicePrice').value = '';
    document.getElementById('serviceUnit').value = 'kg';
    document.getElementById('modalTitle').textContent = mode === 'add' ? 'Tambah Layanan' : 'Edit Layanan';

    if (data) {
        editingId = data.id;
        document.getElementById('serviceId').value = data.id;
        document.getElementById('serviceName').value = data.service_name;
        document.getElementById('servicePrice').value = data.price;
        document.getElementById('serviceUnit').value = data.unit;
    }
    document.getElementById('serviceModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('serviceModal').classList.add('hidden');
}

async function saveService() {

    const btn = document.getElementById('saveServiceBtn');

    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const payload = {
        service_name: document.getElementById('serviceName').value,
        price: Number(document.getElementById('servicePrice').value),
        unit: document.getElementById('serviceUnit').value,
    };

    try {

        if (editingId) {

            await apiFetch(
                `/services/${editingId}`,
                'PUT',
                payload
            );

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Layanan berhasil diperbarui',
                timer: 1800,
                showConfirmButton: false,
                borderRadius: '20px'
            });

        } else {

            await apiFetch(
                '/services',
                'POST',
                payload
            );

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Layanan berhasil ditambahkan',
                timer: 1800,
                showConfirmButton: false,
                borderRadius: '20px'
            });
        }

        closeModal();
        loadServices();

    } catch(e) {

        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: e.message,
            confirmButtonColor: '#ef4444',
            borderRadius: '20px'
        });

    } finally {

        btn.disabled = false;
        btn.textContent = 'Simpan';
    }
}

async function deleteService(id) {

    const result = await Swal.fire({
        title: 'Hapus layanan?',
        text: 'Layanan yang dihapus tidak bisa dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#94a3b8',
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        background: '#fff',
        borderRadius: '20px'
    });

    if (!result.isConfirmed) {
        return;
    }

    try {

        await apiFetch(
            `/services/${id}`,
            'DELETE'
        );

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Layanan berhasil dihapus',
            timer: 1800,
            showConfirmButton: false,
            borderRadius: '20px'
        });

        loadServices();

    } catch(e) {

        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: e.message,
            confirmButtonColor: '#ef4444',
            borderRadius: '20px'
        });
    }
}
</script>
@endpush
