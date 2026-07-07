<?php

namespace App\Providers;
use App\Models\NotaBbm;
use App\Models\LaporanKerusakan;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        view()->composer('*', function ($view) {
            $view->with('totalKerusakanMenunggu', \App\Models\LaporanKerusakan::where('status', 'Menunggu Validasi')->count());
            $view->with('totalNotaBbmMenunggu', \App\Models\NotaBbm::where('status', 'Menunggu Validasi')->count());

            // Total semua nota:
            $view->with('totalNotaMenunggu', $view->totalNotaBbmMenunggu); // tambah hauling, perbaikan kalau ada
        });
    }
}