<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $query = Transaction::with([
            'customer.user',
            'service'
        ]);

        // filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // search invoice
        if ($request->search) {
            $query->where('invoice_code', 'like', '%' . $request->search . '%');
        }

        $transactions = $query
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'service_id' => 'required|exists:services,id',
            'weight' => 'required|numeric',
            'payment_method' => 'required|in:cash,transfer',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

        $service = Service::findOrFail($validated['service_id']);

        $totalPrice = $service->price * $validated['weight'];

        $paymentProof = null;

        if ($request->hasFile('payment_proof')) {
            $paymentProof = $request->file('payment_proof')
                ->store('payment_proofs', 'public');
        }

        $transaction = Transaction::create([
            'invoice_code' => 'LND-' . time(),
            'admin_id' => $request->user()->id,
            'customer_id' => $validated['customer_id'],
            'service_id' => $validated['service_id'],
            'weight' => $validated['weight'],
            'total_price' => $totalPrice,
            'status' => 'antrian',
            'payment_method' => $validated['payment_method'],
            'payment_status' =>
                $validated['payment_method'] === 'cash'
                    ? 'paid'
                    : 'pending',
            'payment_proof' => $paymentProof
                ? asset('storage/' . $paymentProof)
                : null,
            'paid_at' =>
                $validated['payment_method'] === 'cash'
                    ? now()
                    : null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dibuat',
            'data' => $transaction
        ]);
    }

    public function updateStatus(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:antrian,dicuci,disetrika,siap diambil,diambil'
        ]);

        $transaction = Transaction::findOrFail($id);

        $transaction->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate',
            'data' => $transaction
        ]);
    }

    public function statusLaundry(Request $request)
    {
        $customer = Customer::where('user_id', $request->user()->id())->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tidak ditemukan'
            ], 404);
        }

        $transactions = Transaction::with([
            'service',
            'customer.user'
        ])
        ->where('customer_id', $customer->id)
        ->latest()
        ->get();

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }

    // REPORT API
    public function incomeReport()
    {
        $totalIncome = Transaction::where(
            'payment_status',
            'paid'
        )->sum('total_price');

        $totalTransaction = Transaction::count();

        return response()->json([
            'success' => true,
            'total_income' => $totalIncome,
            'total_transaction' => $totalTransaction
        ]);
    }

    public function statistics()
    {
        $todayIncome = Transaction::whereDate(
            'created_at',
            today()
        )->sum('total_price');

        $monthlyIncome = Transaction::whereMonth(
            'created_at',
            now()->month
        )->sum('total_price');

        $totalTransaction = Transaction::count();

        return response()->json([
            'success' => true,

            'today_income' => $todayIncome,

            'monthly_income' => $monthlyIncome,

            'total_transaction' => $totalTransaction
        ]);
    }

    public function history(Request $request)
    {
        $customer = Customer::where(
            'user_id',
            $request->user()->id
        )->first();

        $transactions = Transaction::with('service')
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $transactions
        ]);
    }
}