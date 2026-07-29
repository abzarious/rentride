<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use App\Http\Requests\StoreVehicleTypeRequest;
use App\Http\Requests\UpdateVehicleTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleTypeController extends Controller
{
    /**
     * Tampilkan daftar tipe kendaraan dengan fitur pencarian dan pagination.
     */
    public function index(Request $request)
    {
        $query = VehicleType::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        $vehicleTypes = $query->latest()->paginate(10)->withQueryString();

        return view('admin.vehicle-types.index', compact('vehicleTypes'));
    }

    /**
     * Tampilkan form tambah tipe kendaraan.
     */
    public function create()
    {
        return view('admin.vehicle-types.create');
    }

    /**
     * Simpan data tipe kendaraan baru.
     */
    public function store(StoreVehicleTypeRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($request->name);

        VehicleType::create($validated);

        return redirect()->route('admin.vehicle-types.index')
            ->with('success', 'Tipe kendaraan berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail tipe kendaraan.
     */
    public function show(VehicleType $vehicleType)
    {
        return view('admin.vehicle-types.show', compact('vehicleType'));
    }

    /**
     * Tampilkan form edit tipe kendaraan.
     */
    public function edit(VehicleType $vehicleType)
    {
        return view('admin.vehicle-types.edit', compact('vehicleType'));
    }

    /**
     * Perbarui data tipe kendaraan.
     */
    public function update(UpdateVehicleTypeRequest $request, VehicleType $vehicleType)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($request->name);

        $vehicleType->update($validated);

        return redirect()->route('admin.vehicle-types.index')
            ->with('success', 'Tipe kendaraan berhasil diperbarui!');
    }

    /**
     * Hapus tipe kendaraan (Soft Delete).
     */
    public function destroy(VehicleType $vehicleType)
    {
        $vehicleType->delete();

        return redirect()->route('admin.vehicle-types.index')
            ->with('success', 'Tipe kendaraan berhasil dihapus!');
    }
}