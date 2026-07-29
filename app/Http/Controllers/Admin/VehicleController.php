<?php

namespace App\Http\Controllers\Admin;

use App\Enums\VehicleStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Brand;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\VehicleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vehicle::with(['brand', 'category', 'vehicleType']);

        // 1. Pencarian berdasarkan Nama atau Plat Nomor
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('plate_number', 'like', "%{$search}%");
            });
        }

        // 2. Filter berdasarkan Brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // 3. Filter berdasarkan Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 4. Filter berdasarkan Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $vehicles = $query->latest()->paginate(8)->withQueryString();

        // Data pendukung untuk dropdown filter
        $brands = Brand::orderBy('name')->get();
        $categories = VehicleCategory::orderBy('name')->get();

        return view('admin.vehicles.index', compact('vehicles', 'brands', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $brands = Brand::orderBy('name')->get();
        $categories = VehicleCategory::orderBy('name')->get();
        $types = VehicleType::orderBy('name')->get();
        $statuses = VehicleStatus::cases();

        return view('admin.vehicles.create', compact('brands', 'categories', 'types', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Upload Thumbnail jika ada
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan baru berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle): View
    {
        $brands = Brand::orderBy('name')->get();
        $categories = VehicleCategory::orderBy('name')->get();
        $types = VehicleType::orderBy('name')->get();
        $statuses = VehicleStatus::cases();

        return view('admin.vehicles.edit', compact('vehicle', 'brands', 'categories', 'types', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $request->validated();

        // Handle ganti thumbnail
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada di storage
            if ($vehicle->thumbnail && Storage::disk('public')->exists($vehicle->thumbnail)) {
                Storage::disk('public')->delete($vehicle->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan berhasil diperbarui!');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['brand', 'category', 'vehicleType']);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete(); // Mengisi kolom deleted_at (Soft Delete)

        return redirect()->route('admin.vehicles.index')
            ->with('success', "Kendaraan {$vehicle->name} (Plat: {$vehicle->plate_number}) berhasil dipindahkan ke Sampah.");
    }

    public function trash()
    {
        $trashedVehicles = Vehicle::onlyTrashed()
            ->with(['brand', 'category', 'vehicleType'])
            ->latest()
            ->paginate(8);

        return view('admin.vehicles.trash', compact('trashedVehicles'));
    }

    public function restore($id)
    {
        $vehicle = Vehicle::onlyTrashed()->findOrFail($id);
        $vehicle->restore();

        return redirect()->route('admin.vehicles.trash')
            ->with('success', "Kendaraan {$vehicle->name} berhasil dikembalikan ke daftar aktif.");
    }

    public function forceDelete($id)
    {
        $vehicle = Vehicle::onlyTrashed()->findOrFail($id);

        // Hapus thumbnail dari storage jika ada
        if ($vehicle->thumbnail && Storage::disk('public')->exists($vehicle->thumbnail)) {
            Storage::disk('public')->delete($vehicle->thumbnail);
        }

        $vehicle->forceDelete();

        return redirect()->route('admin.vehicles.trash')
            ->with('success', "Kendaraan {$vehicle->name} berhasil dihapus secara permanen dari database.");
    }
}