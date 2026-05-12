<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Service::latest()->paginate(10)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|in:kiloan,satuan',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:20'
        ]);

        $service = Service::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service berhasil ditambahkan',
            'data' => $service
        ]);
    }

    public function show(string $id)
    {
        $service = Service::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }

    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'service_name' => 'required|in:kiloan,satuan',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:20'
        ]);

        $service->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service berhasil diupdate',
            'data' => $service
        ]);
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);

        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service berhasil dihapus'
        ]);
    }
}