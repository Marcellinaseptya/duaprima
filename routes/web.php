<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CetakJadwalController;
use Illuminate\Http\Request;
use App\Http\Controllers\PasswordResetController;

// Dashboard Controllers
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Manajer\DashboardManajerController;
use App\Http\Controllers\Sopir\DashboardSopirController;
use App\Http\Controllers\Owner\DashboardOwnerController;

// Admin Side Controllers
use App\Http\Controllers\Admin\SopirController;
use App\Http\Controllers\Admin\MasterTrukController;
use App\Http\Controllers\Admin\AdminJadwalOperasionalController;
use App\Http\Controllers\Admin\LaporanKerusakanController;
use App\Http\Controllers\Admin\SparepartController;
use App\Http\Controllers\Admin\PembelianSparepartController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\TripBerangkatController;
use App\Http\Controllers\Admin\TripPulangController;
use App\Http\Controllers\Admin\RitaseController;
use App\Http\Controllers\Admin\GajiSopirController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LaporanKeuanganController;
use App\Http\Controllers\Admin\LaporanNotaHaulingController;
use App\Http\Controllers\Admin\NotaPengeluaranController;
use App\Http\Controllers\Admin\KlienController;

// Manajer Side Controllers
use App\Http\Controllers\Manajer\JadwalOperasionalController;
use App\Http\Controllers\Manajer\ManajerKerusakanController;
use App\Http\Controllers\Manajer\MaintenanceController as ManajerMaintenanceController;
use App\Http\Controllers\Manajer\NotaPengeluaranController as ManajerNotaPengeluaranController;
use App\Http\Controllers\Manajer\NotaHaulingController as ManajerNotaHaulingController;

// Sopir Side Controllers
use App\Http\Controllers\Sopir\JadwalSopirController;
use App\Http\Controllers\Sopir\LaporanKerusakanController as SopirLaporanKerusakanController;
use App\Http\Controllers\Sopir\TripBerangkatController as SopirTripBerangkatController;
use App\Http\Controllers\Sopir\TripPulangController as SopirTripPulangController;
use App\Http\Controllers\Sopir\RitaseController as SopirRitaseController;
use App\Http\Controllers\Sopir\LaporanNotaHaulingController as SopirNotaHaulingController;
use App\Http\Controllers\Sopir\LaporanNotaPengeluaranController;
use App\Http\Controllers\Sopir\RiwayatTripController;

// Owner Side Controllers
use App\Http\Controllers\Owner\RitaseOwnerController;
use App\Http\Controllers\Owner\NotaController as OwnerNotaController;
use App\Http\Controllers\Owner\KerusakanOwnerController;
use App\Http\Controllers\Owner\KeuanganOwnerController;
use App\Http\Controllers\Owner\NotaHaulingOwnerController;
use App\Http\Controllers\Owner\MaintenanceOwnerController;

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARDS
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardOwnerController::class, 'index'])->name('owner.dashboard');
    Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard/manajer', [DashboardManajerController::class, 'index'])->name('manajer.dashboard');
    Route::get('/dashboard/sopir', [DashboardSopirController::class, 'dashboard'])->name('sopir.dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {
        // User Management
        Route::resource('users', UserController::class); // Melingkupi index, create, store, edit, update, destroy
        
        // Master Data
        Route::get('/sopir', [SopirController::class, 'index'])->name('admin.sopir.index');
        Route::get('/sopir/create', [SopirController::class, 'create'])->name('admin.sopir.create');
        Route::post('/sopir', [SopirController::class, 'store'])->name('admin.sopir.store');
        Route::get('/sopir/{sopir}/edit', [SopirController::class, 'edit'])->name('admin.sopir.edit');
        Route::put('/sopir/{sopir}', [SopirController::class, 'update'])->name('admin.sopir.update');
        Route::delete('/sopir/{sopir}', [SopirController::class, 'destroy'])->name('admin.sopir.destroy');

        Route::resource('master-truk', MasterTrukController::class)->names('admin.mastertruk');
        Route::resource('klien', KlienController::class)->names('admin.klien');
        
        // Operasional & Logistik
        Route::get('/jadwal-operasional', [AdminJadwalOperasionalController::class, 'index'])->name('admin.jadwal-operasional.index');
        Route::get('/jadwal-operasional/export', [AdminJadwalOperasionalController::class, 'export'])->name('admin.jadwal-operasional.export');
        
        Route::resource('sparepart', SparepartController::class)->names('admin.sparepart');
        Route::resource('pembelian', PembelianSparepartController::class)->names('admin.pembelian');
        Route::resource('maintenance', MaintenanceController::class)->names('admin.maintenance');
        Route::get('/maintenance/export/pdf', [MaintenanceController::class, 'exportPDF'])->name('admin.maintenance.export');

        // Trip & Ritase
        Route::get('/tripberangkat', [App\Http\Controllers\Admin\TripBerangkatController::class, 'index'])->name('admin.tripberangkat.index');

// Dan jangan lupa tambahkan rute export agar tidak error saat diklik
Route::get('/tripberangkat/export', [App\Http\Controllers\Admin\TripBerangkatController::class, 'export'])->name('admin.tripberangkat.export');
        
        Route::put('trip-pulang/{tripPulang}/tarif', [TripPulangController::class, 'updateTarif'])->name('admin.trippulang.updateTarif');
        Route::patch('trip-pulang/{tripPulang}/approve', [TripPulangController::class, 'approve'])->name('admin.trippulang.approve');
        Route::patch('trip-pulang/{tripPulang}/reject', [TripPulangController::class, 'reject'])->name('admin.trippulang.reject');
        Route::resource('trip-pulang', TripPulangController::class)->names('admin.trippulang');
        
        Route::get('/ritase', [RitaseController::class, 'index'])->name('admin.ritase.index');
        Route::get('/ritase/export', [RitaseController::class, 'export'])->name('admin.ritase.export');

        // Keuangan Admin
        Route::get('/gaji-sopir', [GajiSopirController::class, 'index'])->name('admin.gaji-sopir.index');
        Route::get('/gaji-sopir/export', [GajiSopirController::class, 'export'])->name('admin.gaji-sopir.export');
        Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.invoice.index');
        Route::get('/invoice/export', [InvoiceController::class, 'export'])->name('admin.invoice.export');
        
        Route::resource('nota-pengeluaran', NotaPengeluaranController::class)->names('admin.notapengeluaran');
        Route::get('nota-pengeluaran-export', [NotaPengeluaranController::class, 'export'])->name('admin.notapengeluaran.export');
        
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])->name('admin.laporan_keuangan.index');
        Route::get('/laporan-keuangan/export', [LaporanKeuanganController::class, 'exportPdf'])->name('admin.laporan_keuangan.export');
        
        Route::get('notahauling', [LaporanNotaHaulingController::class, 'index'])->name('admin.nota-hauling.index');
        Route::get('notahauling/export', [LaporanNotaHaulingController::class, 'export'])->name('admin.nota-hauling.export');
        Route::patch('notahauling/{id}/update-status', [LaporanNotaHaulingController::class, 'updateStatus'])->name('admin.nota-hauling.update-status');

        Route::get('/laporan-kerusakan', [LaporanKerusakanController::class, 'index'])->name('admin.laporankerusakan.index');
        Route::get('/laporan-kerusakan/export', [LaporanKerusakanController::class, 'exportPdf'])->name('admin.laporankerusakan.export');

        // Faktur (Invoice) UI
        Route::resource('faktur', App\Http\Controllers\Admin\FakturController::class)->names('admin.faktur');
    });

    /*
    |--------------------------------------------------------------------------
    | MANAJER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('manajer')->name('manajer.')->middleware(['role:manajer'])->group(function () {
        Route::resource('jadwal', JadwalOperasionalController::class);
        Route::get('/jadwal/cetak', [CetakJadwalController::class, 'cetak'])->name('jadwal.cetak');
        
        Route::get('/laporan-kerusakan', [ManajerKerusakanController::class, 'index'])->name('kerusakan.index');
        Route::get('/laporan-kerusakan/{id}', [ManajerKerusakanController::class, 'show'])->name('kerusakan.show');
        Route::put('/laporan-kerusakan/{id}/setujui', [ManajerKerusakanController::class, 'setujui'])->name('kerusakan.setujui');
        Route::put('/laporan-kerusakan/{id}/tolak', [ManajerKerusakanController::class, 'tolak'])->name('kerusakan.tolak');
        Route::get('/laporan-kerusakan/export/pdf', [ManajerKerusakanController::class, 'export'])->name('kerusakan.export');
        
        Route::resource('maintenance', ManajerMaintenanceController::class);
        Route::get('/maintenance/from-laporan/{id}', [ManajerMaintenanceController::class, 'createFromLaporan'])->name('maintenance.fromLaporan');
        Route::get('/maintenance-print', [ManajerMaintenanceController::class, 'print'])->name('maintenance.print');
        Route::resource('nota-pengeluaran', ManajerNotaPengeluaranController::class);
        Route::get('/nota-hauling', [ManajerNotaHaulingController::class, 'index'])->name('nota-hauling.index');

        // Trip Pulang & Approval
        Route::put('trip-pulang/{tripPulang}/tarif', [App\Http\Controllers\Manajer\TripPulangController::class, 'updateTarif'])->name('trippulang.updateTarif');
        Route::patch('trip-pulang/{tripPulang}/approve', [App\Http\Controllers\Manajer\TripPulangController::class, 'approve'])->name('trippulang.approve');
        Route::patch('trip-pulang/{tripPulang}/reject', [App\Http\Controllers\Manajer\TripPulangController::class, 'reject'])->name('trippulang.reject');
        Route::resource('trip-pulang', App\Http\Controllers\Manajer\TripPulangController::class)->names('trippulang');

        // Faktur (Invoice) UI
        Route::resource('faktur', App\Http\Controllers\Manajer\FakturController::class)->names('faktur');
    });

    /*
    |--------------------------------------------------------------------------
    | SOPIR ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('sopir')->name('sopir.')->middleware(['role:sopir'])->group(function () {
        // Kontrol Jadwal
        Route::post('/jadwal/{jadwal}/mulai', [JadwalSopirController::class, 'mulai'])->name('jadwal.mulai');
        Route::post('/jadwal/{jadwal}/selesai', [JadwalSopirController::class, 'selesai'])->name('jadwal.selesai');
        Route::post('/jadwal/{jadwal}/batal', [JadwalSopirController::class, 'batal'])->name('jadwal.batal');

        // Laporan & Nota
        Route::resource('laporan-kerusakan', SopirLaporanKerusakanController::class)->only(['index', 'create', 'store']);
        Route::resource('laporan-nota-hauling', SopirNotaHaulingController::class);
        Route::resource('nota-pengeluaran', LaporanNotaPengeluaranController::class);
        
        // Trip & Ritase
        Route::get('/trip-berangkat', [SopirTripBerangkatController::class, 'index'])->name('trip-berangkat.index');
        Route::get('/trip-berangkat/create', [SopirTripBerangkatController::class, 'create'])->name('trip-berangkat.create');
        Route::post('/trip-berangkat/store', [SopirTripBerangkatController::class, 'store'])->name('trip-berangkat.store');
        
        Route::get('/trip-pulang', [SopirTripPulangController::class, 'index'])->name('trip-pulang.index');
        Route::get('/trip-pulang/{id}/form', [SopirTripPulangController::class, 'form'])->name('trip-pulang.form');
        Route::post('/trip-pulang/{id}/store', [SopirTripPulangController::class, 'store'])->name('trip-pulang.store');
        
        Route::resource('ritase', SopirRitaseController::class);
        Route::get('/riwayat-trip', [RiwayatTripController::class, 'index'])->name('riwayat-trip.index');
    });

    /*
    |--------------------------------------------------------------------------
    | OWNER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('owner')->name('owner.')->middleware(['role:owner'])->group(function () {
        Route::get('/ritase', [RitaseOwnerController::class, 'index'])->name('ritase.index');
        Route::get('/nota/bbm', [OwnerNotaController::class, 'bbm'])->name('nota.bbm');
        Route::get('/nota/perbaikan', [OwnerNotaController::class, 'perbaikan'])->name('nota.perbaikan');
        Route::get('/kerusakan', [KerusakanOwnerController::class, 'index'])->name('kerusakan.index');
        Route::get('/keuangan', [KeuanganOwnerController::class, 'index'])->name('keuangan.index');
        Route::get('/maintenance', [MaintenanceOwnerController::class, 'index'])->name('maintenance.index');
        
        Route::get('/nota-hauling', [NotaHaulingOwnerController::class, 'index'])->name('nota-hauling.index');
        Route::post('/nota-hauling/{id}/approve', [NotaHaulingOwnerController::class, 'approve'])->name('nota-hauling.approve');
        Route::post('/nota-hauling/{id}/reject', [NotaHaulingOwnerController::class, 'reject'])->name('nota-hauling.reject');
    });


   

// 1. Menampilkan form lupa password (yang tadi kita buat HTML-nya)
Route::get('/forgot-password', function () {
    // Sesuaikan 'auth.forgot-password' dengan lokasi file blade kamu
    return view('auth.forgot-password'); 
})->middleware('guest')->name('password.request');

// 2. Memproses pengiriman email link reset password
Route::post('/forgot-password', [PasswordResetController::class, 'kirimEmail'])
    ->middleware('guest')->name('password.email');

// 3. Menampilkan form reset password (saat user klik link dari email)
Route::get('/reset-password/{token}', function (string $token, Request $request) {
    return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
})->middleware('guest')->name('password.reset');

// 4. Memproses perubahan password baru ke database
Route::post('/reset-password', [PasswordResetController::class, 'prosesReset'])
    ->middleware('guest')->name('password.update');

});