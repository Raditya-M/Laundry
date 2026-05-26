@extends('layouts.app')

@section('title', 'Pelanggan')
@section('page-title', 'Pelanggan')
@section('page-subtitle', 'Kelola data pelanggan')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-display font-700 text-slate-700">
                Daftar Pelanggan
            </h2>

            <p class="text-xs text-slate-400 mt-0.5" id="customerCount">
                —
            </p>
        </div>

        <button
            onclick="openCustModal('add')"
            class="flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium px-4 py-2.5 rounded-xl transition-colors shadow shadow-primary-200"
        >
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah Pelanggan
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50/50">
                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        #
                    </th>

                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Nama
                    </th>

                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Username
                    </th>

                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Membership
                    </th>

                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Telepon
                    </th>

                    <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Alamat
                    </th>

                    <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody id="customerTable">
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-slate-400">
                        <i class="fa-solid fa-spinner fa-spin text-2xl mb-3 block text-primary-300"></i>
                        Memuat...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div
    id="customerModal"
    class="fixed inset-0 z-50 hidden modal-overlay bg-black/50 flex items-center justify-center p-4"
>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3
                class="font-display font-700 text-slate-700"
                id="custModalTitle"
            >
                Tambah Pelanggan
            </h3>

            <button
                onclick="closeCustModal()"
                class="w-8 h-8 rounded-lg hover:bg-slate-100 flex items-center justify-center text-slate-400"
            >
                <i class="fa-solid fa-times"></i>
            </button>
        </div>

        <div class="p-6 space-y-4">
            <input type="hidden" id="custId">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">
                        Nama
                    </label>

                    <input
                        type="text"
                        id="custName"
                        placeholder="Nama lengkap"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm"
                    >
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">
                        Username
                    </label>

                    <input
                        type="text"
                        id="custUsername"
                        placeholder="username"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm"
                    >
                </div>

                <div class="col-span-2">
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">
                        Telepon
                    </label>

                    <input
                        type="text"
                        id="custPhone"
                        placeholder="08xx"
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm"
                    >
                </div>
            </div>

            <div id="custPasswordField">
                <label class="block text-xs font-medium text-slate-500 mb-1.5">
                    Password
                </label>

                <input
                    type="password"
                    id="custPassword"
                    placeholder="Min 6 karakter"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm"
                >
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-500 mb-1.5">
                    Alamat
                </label>

                <textarea
                    id="custAddress"
                    rows="2"
                    placeholder="Alamat lengkap"
                    class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm resize-none"
                ></textarea>
            </div>
        </div>

        <div class="px-6 pb-6 flex gap-3">
            <button
                onclick="closeCustModal()"
                class="flex-1 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition"
            >
                Batal
            </button>

            <button
                onclick="saveCustomer()"
                id="saveCustBtn"
                class="flex-1 py-2.5 rounded-xl bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium transition shadow shadow-primary-200"
            >
                Simpan
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

let editingCustId = null;

document.addEventListener('DOMContentLoaded', () => {
    checkAuth();
    loadCustomers();
});

async function loadCustomers() {

    try {

        const data = await apiFetch('/customers');

        const customers = data.data.data ?? [];

        document.getElementById('customerCount').textContent =
            `${customers.length} pelanggan terdaftar`;

        if (!customers.length) {

            document.getElementById('customerTable').innerHTML = `
                <tr>
                    <td colspan="7"
                        class="px-6 py-10 text-center text-slate-400">
                        Belum ada pelanggan
                    </td>
                </tr>
            `;

            return;
        }

        document.getElementById('customerTable').innerHTML =
            customers.map((c, i) => {

                const expiredAt = c.user?.membership_expired_at;

                const isMember =
                    expiredAt &&
                    new Date(expiredAt) > new Date();

                return `
                    <tr class="border-b border-slate-50 hover:bg-slate-50/50 transition-colors">

                        <td class="px-6 py-3.5 text-slate-400 text-xs font-mono">
                            ${i + 1}
                        </td>

                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">

                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-primary-600 font-display font-700 text-xs">
                                        ${c.user?.name?.charAt(0).toUpperCase() ?? 'P'}
                                    </span>
                                </div>

                                <span class="font-medium text-slate-700">
                                    ${c.user?.name ?? '-'}
                                </span>

                            </div>
                        </td>

                        <td class="px-6 py-3.5 text-slate-500 font-mono text-xs">
                            ${c.user?.username ?? '—'}
                        </td>

                        <td class="px-6 py-3.5">

                            ${
                                isMember
                                ?
                                `
                                <div class="inline-flex flex-col">
                                    <span class="px-2 py-1 rounded-lg text-[11px] font-semibold bg-emerald-100 text-emerald-700 w-fit">
                                        AKTIF
                                    </span>

                                    <span class="text-[10px] text-slate-400 mt-1">
                                        sampai ${new Date(expiredAt).toLocaleDateString('id-ID')}
                                    </span>
                                </div>
                                `
                                :
                                `
                                <span class="px-2 py-1 rounded-lg text-[11px] font-semibold bg-red-100 text-red-600">
                                    NON MEMBER
                                </span>
                                `
                            }

                        </td>

                        <td class="px-6 py-3.5 text-slate-500 font-mono text-xs">
                            ${c.user?.phone ?? '—'}
                        </td>

                        <td class="px-6 py-3.5 text-slate-400 text-xs max-w-[160px] truncate">
                            ${c.user?.address ?? '—'}
                        </td>

                        <td class="px-6 py-3.5 text-right">

                            <button
                                onclick="openCustModal('edit', ${JSON.stringify(c).replace(/"/g,'&quot;')})"
                                class="text-xs text-primary-500 hover:text-primary-700 font-medium px-3 py-1.5 rounded-lg hover:bg-primary-50 transition mr-1"
                            >
                                <i class="fa-solid fa-pen"></i>
                                Edit
                            </button>

                            <button
                                onclick="deleteCustomer(${c.id})"
                                class="text-xs text-red-400 hover:text-red-600 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50 transition"
                            >
                                <i class="fa-solid fa-trash"></i>
                                Hapus
                            </button>

                        </td>
                    </tr>
                `;
            }).join('');

    } catch (e) {

        showToast(e.message, 'error');

    }
}

function openCustModal(mode, data = null) {

    editingCustId = null;

    [
        'custId',
        'custName',
        'custUsername',
        'custPhone',
        'custPassword',
        'custAddress'
    ].forEach(id => {
        document.getElementById(id).value = '';
    });

    document.getElementById('custModalTitle').textContent =
        mode === 'add'
            ? 'Tambah Pelanggan'
            : 'Edit Pelanggan';

    document.getElementById('custPasswordField').style.display =
        mode === 'add'
            ? 'block'
            : 'none';

    if (data) {

        editingCustId = data.id;

        document.getElementById('custId').value =
            data.id;

        document.getElementById('custName').value =
            data.user?.name ?? '';

        document.getElementById('custUsername').value =
            data.user?.username ?? '';

        document.getElementById('custPhone').value =
            data.user?.phone ?? '';

        document.getElementById('custAddress').value =
            data.user?.address ?? '';
    }

    document.getElementById('customerModal')
        .classList.remove('hidden');
}

function closeCustModal() {

    document.getElementById('customerModal')
        .classList.add('hidden');
}

async function saveCustomer() {

    const btn = document.getElementById('saveCustBtn');

    btn.disabled = true;
    btn.textContent = 'Menyimpan...';

    const payload = {

        name:
            document.getElementById('custName').value,

        username:
            document.getElementById('custUsername').value,

        phone:
            document.getElementById('custPhone').value,

        address:
            document.getElementById('custAddress').value,
    };

    if (!editingCustId) {

        payload.password =
            document.getElementById('custPassword').value;
    }

    try {

        if (editingCustId) {

            await apiFetch(
                `/customers/${editingCustId}`,
                'PUT',
                payload
            );

            showToast(
                'Pelanggan berhasil diperbarui',
                'success'
            );

        } else {

            await apiFetch(
                '/customers',
                'POST',
                payload
            );

            showToast(
                'Pelanggan berhasil ditambahkan',
                'success'
            );
        }

        closeCustModal();

        loadCustomers();

    } catch (e) {

        showToast(e.message, 'error');

    } finally {

        btn.disabled = false;

        btn.textContent = 'Simpan';
    }
}

async function deleteCustomer(id) {

    if (!confirm('Hapus pelanggan ini?')) {
        return;
    }

    try {

        await apiFetch(
            `/customers/${id}`,
            'DELETE'
        );

        showToast(
            'Pelanggan dihapus',
            'success'
        );

        loadCustomers();

    } catch (e) {

        showToast(e.message, 'error');
    }
}

</script>
@endpush
