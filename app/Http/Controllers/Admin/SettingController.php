<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::getSetting();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::getSetting();

        $request->validate([
            'company_name'    => 'required|string|max:255',
            'whatsapp'        => 'required|string|max:20',
            'phone'           => 'nullable|string|max:20',
            'email'           => 'nullable|email|max:255',
            'address'         => 'nullable|string',
            'primary_color'   => 'required|string|max:10',
            'secondary_color' => 'required|string|max:10',
            'bank_name'       => 'nullable|string|max:100',
            'bank_number'     => 'nullable|string|max:100',
            'bank_holder'     => 'nullable|string|max:255',
            'logo'            => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        $data = $request->except(['logo']);

        // Format WA agar selalu menggunakan kode negara 62
        $wa = preg_replace('/[^0-9]/', '', $request->whatsapp);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        $data['whatsapp'] = $wa;

        // Programmer C Logic Integration - Upload Logo
        if ($request->hasFile('logo')) {
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        $setting->update($data);

        return redirect()->back()->with('success', 'Pengaturan sistem berhasil diperbarui!');
    }
}