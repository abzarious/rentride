<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan Profil
    public function index()
    {
        $user = Auth::user()->load('profile');
        return view('profile.index', compact('user'));
    }

    // Form Edit Profil
    public function edit()
    {
        $user = Auth::user()->load('profile');
        return view('profile.edit', compact('user'));
    }

    // Update Data Profil & Foto
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
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

        // Update Tabel Users
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Update/Create Tabel Profiles
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        if ($request->hasFile('photo')) {
            if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
                Storage::disk('public')->delete($profile->photo);
            }
            $profile->photo = $request->file('photo')->store('profiles', 'public');
        }

        $profile->user_id    = $user->id;
        $profile->phone      = $request->phone;
        $profile->address    = $request->address;
        $profile->nik        = $request->nik;
        $profile->sim_number = $request->sim_number;
        $profile->save();

        return redirect()->route('customer.profile.index')->with('success', 'Profil dan foto akun berhasil diperbarui!');
    }

    // Update Password Akun
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.confirmed'        => 'Konfirmasi password baru tidak cocok.',
            'password.min'              => 'Password baru minimal 8 karakter.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('customer.profile.index')->with('success', 'Password akun Anda berhasil diperbarui!');
    }
}