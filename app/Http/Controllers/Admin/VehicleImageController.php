<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleImageController extends Controller
{
    /**
     * Tampilkan Halaman Galeri Foto Kendaraan
     */
    public function index(Vehicle $vehicle)
    {
        // Load relasi images, brand, category, dan vehicleType
        $vehicle->load(['images', 'brand', 'category', 'vehicleType']);

        return view('admin.vehicles.images', compact('vehicle'));
    }

    /**
     * Upload Multiple Foto Kendaraan
     */
    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'images.required' => 'Pilih setidaknya satu gambar untuk diunggah.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar yang diperbolehkan: JPG, JPEG, PNG, WEBP.',
            'images.*.max' => 'Ukuran maksimal per gambar adalah 2MB.',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // Simpan gambar ke storage public/vehicles/gallery
                $path = $file->store('vehicles/gallery', 'public');

                // Simpan record ke database
                $vehicle->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Berhasil mengunggah gambar kendaraan!');
    }

    /**
     * Hapus Foto Kendaraan
     */
    public function destroy(VehicleImage $image)
    {
        // Hapus file fisik dari storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Hapus record di database
        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
    }
}