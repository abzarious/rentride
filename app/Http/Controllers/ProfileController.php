<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('profile');
        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user()->load('profile');
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:500',
            'nik'        => 'nullable|string|max:20',
            'sim_number' => 'nullable|string|max:30',
            'photo'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. Update Tabel Users
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // 2. Cek/Create Relasi Profile
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // Handle Upload Foto Profil
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }

            // Simpan foto baru
            $photoPath = $request->file('photo')->store('profiles', 'public');
            $profile->photo = $photoPath;
        }

        $profile->user_id    = $user->id;
        $profile->phone      = $request->phone;
        $profile->address    = $request->address;
        $profile->nik        = $request->nik;
        $profile->sim_number = $request->sim_number;
        $profile->save();

        return redirect()->route('customer.profile.index')->with('success', 'Profil dan foto berhasil diperbarui!');
    }
} 