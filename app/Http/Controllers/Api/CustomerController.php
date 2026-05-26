<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user')
                    ->latest()
                    ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $customers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6',
            'phone' => 'required|max:15',
            'address' => 'required'
        ]);

        // Buat user
        $user = User::create([
            'name' => trim($validated['name']),
            'username' => trim($validated['username']),
            'password' => bcrypt($validated['password']),
            'role' => 'customer',
            'phone' => trim($validated['phone']),
            'address' => trim($validated['address']),
        ]);

        // Buat customer profile
        $customer = Customer::create([
            'user_id' => $user->id,
            'phone' => trim($validated['phone']),
            'address' => trim($validated['address'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dibuat',
            'data' => $customer->load('user')
        ]);
    }

    public function show(string $id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $customer
        ]);
    }

    public function update(Request $request, string $id)
    {
        $customer = Customer::with('user')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $customer->user_id,
            'phone' => 'required|max:15',
            'address' => 'required'
        ]);

        // Update user
        $customer->user->update([
            'name' => trim($validated['name']),
            'username' => trim($validated['username']),
            'phone' => trim($validated['phone']),
            'address' => trim($validated['address']),
        ]);

        // Update customer
        $customer->update([
            'phone' => trim($validated['phone']),
            'address' => trim($validated['address'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil diupdate',
            'data' => $customer->load('user')
        ]);
    }

    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        // hapus user juga
        $customer->user()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer berhasil dihapus'
        ]);
    }
}
