<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use App\Http\Requests\StoreVehicleCategoryRequest;
use App\Http\Requests\UpdateVehicleCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = VehicleCategory::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('admin.vehicle-categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('admin.vehicle-categories.create');
    }

    public function store(StoreVehicleCategoryRequest $request)
    {
        VehicleCategory::create([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vehicle-categories.index')
            ->with('success', 'Kategori kendaraan berhasil ditambahkan!');
    }

    public function show(VehicleCategory $vehicleCategory)
    {
        return view('admin.vehicle-categories.show', compact('vehicleCategory'));
    }

    public function edit(VehicleCategory $vehicleCategory)
    {
        return view('admin.vehicle-categories.edit', compact('vehicleCategory'));
    }

    public function update(UpdateVehicleCategoryRequest $request, VehicleCategory $vehicleCategory)
    {
        $vehicleCategory->update([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vehicle-categories.index')
            ->with('success', 'Kategori kendaraan berhasil diperbarui!');
    }

    public function destroy(VehicleCategory $vehicleCategory)
    {
        // Opsional: Cek jika kategori sudah dipakai oleh kendaraan sebelum dihapus
        if ($vehicleCategory->vehicles()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Kategori tidak bisa dihapus karena masih terikat dengan data kendaraan.');
        }

        $vehicleCategory->delete();

        return redirect()->route('admin.vehicle-categories.index')
            ->with('success', 'Kategori kendaraan berhasil dihapus!');
    }
}