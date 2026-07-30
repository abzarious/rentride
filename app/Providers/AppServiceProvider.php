<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Bagikan variabel $setting ke seluruh tampilan Blade jika tabel settings sudah ada
        if (Schema::hasTable('settings')) {
            View::share('setting', Setting::getSetting());
        }
    }
}