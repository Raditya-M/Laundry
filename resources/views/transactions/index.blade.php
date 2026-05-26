@extends('layouts.app')

@section('title', 'Transaksi')
@section('page-title', 'Transaksi')
@section('page-subtitle', 'Kelola transaksi laundry')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-display font-700 text-slate-700">Daftar Transaksi</h2>
            <p class="text-xs text-slate-400 mt-0.5" id="trxCount">—</p>
        </div>
        <button onclick="openTrxModal()" class="flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors shadow shadow-primary-200">
            <i class="fa-solid fa-plus text-xs"></i> Buat Transaksi
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Layanan</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Berat / Jumlah</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Total</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pembayaran</th>
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="trxTable">
                <tr><td colspan="8" class="px-6 py-10 text-center text-slate-400">
                    <i class="fa-solid fa-spinner fa-spin text-2xl mb-3 block text-primary-300"></i>Memuat...
                </td></tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Create Transaction Modal -->
<div id="trxModal" class="fixed inset-0 z-50 hidden modal-overlay bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between sticky top-0 bg-white z-10">
            <h3 class="font-display font-700 text-slate-700">Buat Transaksi Baru</h3>
            <button onclick="closeTrxModal()" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Pelanggan</label>
                <select id="trxCustomer"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-50 transition">
                    <option value="">Pilih pelanggan...</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Layanan</label>
                <select id="trxService" onchange="calcTotal()"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-50 transition">
                    <option value="">Pilih layanan...</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Berat (kg) / Jumlah (pcs)</label>
                    <input type="number" id="trxWeight" placeholder="0" min="0" step="0.5" oninput="calcTotal()"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-50 transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Total Harga</label>
                    <div class="w-full border border-slate-200 bg-slate-50 rounded-xl px-4 py-2.5 text-sm font-mono text-primary-600 font-medium" id="trxTotalDisplay">Rp 0</div>
                    <input type="hidden" id="trxTotal">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Metode Pembayaran</label>
                <select id="trxPayment"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-50 transition">
                    <option value="cash">Cash</option>
                    <option value="transfer">Transfer</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Bukti Pembayaran (opsional)</label>
                <input type="file" id="trxProof" accept="image/*" placeholder="URL atau nomor referensi"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-50 transition">
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="closeTrxModal()" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition">Batal</button>
            <button onclick="saveTrx()" id="saveTrxBtn" class="flex-1 py-2.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium transition shadow shadow-primary-200">Buat Transaksi</button>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div id="statusModal" class="fixed inset-0 z-50 hidden modal-overlay bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-display font-700 text-slate-700">Update Status</h3>
            <button onclick="closeStatusModal()" class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <input type="hidden" id="statusTrxId">
            <label class="block text-xs font-medium text-slate-500 mb-2">Pilih Status Baru</label>
            <div class="space-y-2" id="statusOptions"></div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="closeStatusModal()" class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition">Batal</button>
            <button onclick="saveStatus()" id="saveStatusBtn" class="flex-1 py-2.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium transition">Update</button>
        </div>
    </div>
</div>

<!-- Payment Proof Modal -->
<div id="proofModal"
    class="fixed inset-0 z-50 hidden bg-black/70 flex items-center justify-center p-4">

    <div class="relative max-w-3xl w-full">

        <button onclick="closeProofModal()"
            class="absolute -top-12 right-0 text-white text-2xl hover:text-slate-300">
            <i class="fa-solid fa-times"></i>
        </button>

        <img id="proofImage"
            src=""
            class="w-full max-h-[85vh] object-contain rounded-2xl bg-white">
    </div>
</div>
@endsection

@push('scripts')
<script>
let allServices = [];
let selectedStatus = null;

const STATUS_LIST = ['antrian', 'dicuci', 'disetrika', 'siap diambil', 'diambil'];

document.addEventListener('DOMContentLoaded', () => {
    checkAuth();
    loadTransactions();
    loadServicesForTrx();
    loadCustomersForTrx();
});

async function loadTransactions() {
    try {
        const data = await apiFetch('/transactions');
        const trxs = data.data.data ?? [];
        document.getElementById('trxCount').textContent = `${trxs.length} transaksi`;

        if (!trxs.length) {
            document.getElementById('trxTable').innerHTML =
                `<tr><td colspan="8" class="px-6 py-10 text-center text-slate-400">Belum ada transaksi</td></tr>`;
            return;
        }

        document.getElementById('trxTable').innerHTML = trxs.map((t, i) => `
            <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-3.5 text-slate-400 text-xs font-mono">${i+1}</td>
                <td class="px-6 py-3.5 font-medium text-slate-700">${t.customer?.user?.username ?? '—'}</td>
                <td class="px-6 py-3.5 text-slate-500 text-xs">${t.service?.service_name ?? '—'}</td>
                <td class="px-6 py-3.5 text-slate-500 font-mono">${formatWeight(t.weight, t.service?.unit)}</td>
                <td class="px-6 py-3.5 font-mono font-medium text-primary-600">${formatRupiah(t.total_price)}</td>
                <td class="px-6 py-3.5"><span class="badge bg-slate-100 text-slate-600 capitalize">${t.payment_method ?? '—'}</span></td>
                <td class="px-6 py-3.5">${statusBadge(t.status)}</td>
                <td class="px-6 py-3.5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        ${t.payment_proof ? `
                            <button onclick="openProofModal('${t.payment_proof}')"
                                class="text-xs text-emerald-600 hover:text-emerald-700 font-medium px-3 py-1.5 rounded-lg hover:bg-emerald-50 transition">
                                <i class="fa-solid fa-receipt"></i> Bukti
                            </button>
                        ` : ''}

                        <button onclick="openStatusModal(${t.id}, '${t.status}')"
                            class="text-xs text-indigo-500 hover:text-indigo-700 font-medium px-3 py-1.5 rounded-lg hover:bg-indigo-50 transition">
                            <i class="fa-solid fa-arrow-up-right-dots"></i> Status
                        </button>

                        <button onclick="deleteTransaction(${t.id})"
                            class="text-xs text-red-500 hover:text-red-700 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50 transition">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    } catch(e) { showToast(e.message, 'error'); }
}

async function loadServicesForTrx() {
    try {
        const data = await apiFetch('/services');
        allServices = data.data.data ?? [];
        const sel = document.getElementById('trxService');
        sel.innerHTML = '<option value="">Pilih layanan...</option>' +
            allServices.map(s => `<option value="${s.id}" data-price="${s.price}">${s.service_name} — ${formatRupiah(s.price)}/${s.unit}</option>`).join('');
    } catch(e) {}
}

async function loadCustomersForTrx() {
    try {
        const data = await apiFetch('/customers');
        const customers = data.data.data ?? [];
        const sel = document.getElementById('trxCustomer');
        sel.innerHTML = '<option value="">Pilih pelanggan...</option>' +
            customers.map(c => `
                <option value="${c.id}">
                    ${c.user?.username ?? 'Tanpa Nama'}
                </option>
            `).join('');
    } catch(e) {}
}

function calcTotal() {
    const sel = document.getElementById('trxService');
    const opt = sel.options[sel.selectedIndex];
    const price = Number(opt?.dataset?.price ?? 0);
    const weight = Number(document.getElementById('trxWeight').value) || 0;
    const total = price * weight;
    document.getElementById('trxTotal').value = total;
    document.getElementById('trxTotalDisplay').textContent = formatRupiah(total);
}

function openTrxModal() { document.getElementById('trxModal').classList.remove('hidden'); }
function closeTrxModal() { document.getElementById('trxModal').classList.add('hidden'); }

async function saveTrx() {
    const btn = document.getElementById('saveTrxBtn');

    btn.disabled = true;
    btn.textContent = 'Memproses...';

    const formData = new FormData();

    formData.append('customer_id', document.getElementById('trxCustomer').value);
    formData.append('service_id', document.getElementById('trxService').value);
    formData.append('weight', document.getElementById('trxWeight').value);
    formData.append('payment_method', document.getElementById('trxPayment').value);

    const proof = document.getElementById('trxProof').files[0];

    if (proof) {
        formData.append('payment_proof', proof);
    }

    try {
        const token = localStorage.getItem('laundry_token');

        const response = await fetch('http://172.16.0.65:8000/api/transactions', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: formData
        });

        const text = await response.text();

        let data;

        try {
            data = JSON.parse(text);
        } catch {
            console.log(text);
            throw new Error('Response bukan JSON');
        }

        if (!response.ok) {
            throw new Error(data.message || 'Gagal membuat transaksi');
        }

        showToast('Transaksi berhasil dibuat', 'success');

        closeTrxModal();
        loadTransactions();

    } catch (e) {
        console.error(e);
        showToast(e.message, 'error');
    } finally {
        btn.disabled = false;
        btn.textContent = 'Buat Transaksi';
    }
}

function openStatusModal(id, currentStatus) {
    document.getElementById('statusTrxId').value = id;
    selectedStatus = currentStatus;

    document.getElementById('statusOptions').innerHTML = STATUS_LIST.map(s => `
        <label class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition ${s === currentStatus ? 'border-primary-400 bg-primary-50' : 'border-slate-100 hover:bg-slate-50'}" onclick="selectStatus('${s}', this)">
            <input type="radio" name="statusRadio" value="${s}" ${s === currentStatus ? 'checked' : ''} class="accent-primary-500">
            <span class="text-sm font-medium text-slate-700 capitalize">${s}</span>
            ${statusBadge(s)}
        </label>
    `).join('');

    document.getElementById('statusModal').classList.remove('hidden');
}

function selectStatus(val, el) {
    selectedStatus = val;
    document.querySelectorAll('#statusOptions label').forEach(l => {
        l.classList.remove('border-primary-400', 'bg-primary-50');
        l.classList.add('border-slate-100');
    });
    el.classList.add('border-primary-400', 'bg-primary-50');
    el.classList.remove('border-slate-100');
}

function closeStatusModal() { document.getElementById('statusModal').classList.add('hidden'); }

async function saveStatus() {
    const id = document.getElementById('statusTrxId').value;
    const checked = document.querySelector('input[name="statusRadio"]:checked');
    if (!checked) return;
    const btn = document.getElementById('saveStatusBtn');
    btn.disabled = true; btn.textContent = 'Menyimpan...';

    try {
        await apiFetch(`/transactions/${id}/status`, 'PUT', { status: checked.value });
        showToast('Status berhasil diperbarui', 'success');
        closeStatusModal();
        loadTransactions();
    } catch(e) { showToast(e.message, 'error'); }
    finally { btn.disabled = false; btn.textContent = 'Update'; }
}

function openProofModal(image) {
    document.getElementById('proofImage').src = image;
    document.getElementById('proofModal').classList.remove('hidden');
}

function closeProofModal() {
    document.getElementById('proofModal').classList.add('hidden');
}

async function deleteTransaction(id) {

    const result = await Swal.fire({
        title: 'Hapus transaksi?',
        text: 'Data transaksi yang dihapus tidak bisa dikembalikan.',
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
            `/transactions/${id}`,
            'DELETE'
        );

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: 'Transaksi berhasil dihapus',
            timer: 1800,
            showConfirmButton: false,
            borderRadius: '20px'
        });

        loadTransactions();

    } catch (e) {

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
