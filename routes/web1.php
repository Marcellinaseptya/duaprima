<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Manajer\DashboardManajerController;
use App\Http\Controllers\Sopir\DashboardSopirController;
use App\Http\Controllers\Owner\DashboardOwnerController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\TrukController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController as SopirLaporanController;

use App\Http\Controllers\Sopir\NotaController;

use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;



// Dashboard Owner
Route::get('/dashboard', [DashboardOwnerController::class, 'index'])
    ->name('owner.dashboard');

// Dashboard Admin
Route::get('/dashboard/admin', [DashboardAdminController::class, 'index'])
    ->name('admin.dashboard');

// Dashboard Manajer
Route::get('/dashboard/manajer', [DashboardManajerController::class, 'index'])
    ->name('manajer.dashboard');

// Dashboard Sopir
Route::get('/dashboard/sopir', [DashboardSopirController::class, 'dashboard'])
    ->name('sopir.dashboard');

//DATA TRUK//

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


//CETAK JADWAL

use App\Http\Controllers\CetakJadwalController;


Route::get('/manajer/jadwal/cetak', [CetakJadwalController::class, 'cetak'])->name('jadwal.cetak');



// CRUD JADWALMANAJER//
Route::prefix('manajer')->group(function () {
    Route::get('/jadwal-operasional', [JadwalOperasionalController::class, 'index'])->name('jadwal-operasional.index');
    Route::get('/jadwal-operasional/create', [JadwalOperasionalController::class, 'create'])->name('jadwal-operasional.create');
    Route::post('/jadwal-operasional', [JadwalOperasionalController::class, 'store'])->name('jadwal-operasional.store');
    Route::get('/jadwal-operasional/{id}/edit', [JadwalOperasionalController::class, 'edit'])->name('jadwal-operasional.edit');
    Route::put('/jadwal-operasional/{id}', [JadwalOperasionalController::class, 'update'])->name('jadwal-operasional.update');
    Route::delete('/jadwal-operasional/{id}', [JadwalOperasionalController::class, 'destroy'])->name('jadwal-operasional.destroy');
});

//ADMIN JADWAL//
use App\Http\Controllers\Admin\AdminJadwalOperasionalController;


Route::middleware(['auth'])->group(function () {
    Route::get('/jadwal-operasional', [AdminJadwalOperasionalController::class, 'index'])->name('admin.jadwal-operasional.index');
    Route::get('/jadwal-operasional/export', [AdminJadwalOperasionalController::class, 'export'])->name('admin.jadwal-operasional.export');
});

//LAPORAN SOPIR//

        Route::prefix('sopir')->name('sopir.')->group(function () {
            Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
            Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
            Route::get('/laporan/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
            Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
            Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
        });
       
        //ADMIN BIKIN SOPIR//


            //JADWAL SOPIR//
            Route::post('/sopir/jadwal/{id}/batal', [SopirController::class, 'batalBerangkat'])->name('sopir.jadwal.batal');
            Route::post('/sopir/jadwal/{id}/selesai', [SopirController::class, 'selesaikanPerjalanan'])->name('sopir.jadwal.selesai');

                
                use App\Http\Controllers\Manajer\LaporanKerusakanController as ManajerLaporanKerusakanController;
                use App\Http\Controllers\Sopir\LaporanKerusakanController as SopirLaporanKerusakanController;
                
// MANAGER

// SOPIR
Route::prefix('sopir/laporan-kerusakan')->name('sopir.laporan-kerusakan.')->middleware(['auth'])->group(function () {
    Route::get('/', [SopirLaporanKerusakanController::class, 'index'])->name('index');
    Route::get('/create', [SopirLaporanKerusakanController::class, 'create'])->name('create');
    Route::post('/store', [SopirLaporanKerusakanController::class, 'store'])->name('store');
});

use App\Http\Controllers\Admin\LaporanKerusakanController;

// URUTAN HARUS DARI YANG SPESIFIK DULU
Route::get('/laporan-kerusakan/export/pdf', [LaporanKerusakanController::class, 'exportPdf'])->name('admin.laporan-kerusakan.export');

Route::get('/laporan-kerusakan', [LaporanKerusakanController::class, 'index'])->name('admin.laporan-kerusakan.index');

// (Opsional, kalau ada detailnya)
Route::get('/laporan-kerusakan/{id}', [LaporanKerusakanController::class, 'show'])->name('admin.laporan-kerusakan.show');


 use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    // List user
    Route::get('/users', [UserController::class, 'users'])->name('users');

    // Tambah user
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Edit user
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    // Hapus user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});


            
            use App\Http\Controllers\Admin\RitaseController;

            
                Route::get('/ritase', [RitaseController::class, 'index'])->name('admin.ritase.index');
                Route::get('/ritase/export', [RitaseController::class, 'export'])->name('admin.ritase.export');
          
               
                Route::get('/ritase/export', [RitaseController::class, 'export'])->name('admin.ritase.export');
          Route::get('/master-truk/{masterTruk}/edit', [MasterTrukController::class, 'edit'])->name('admin.mastertruk.edit');
               
                use App\Http\Controllers\Admin\MasterTrukController;

Route::get('/master-truk', [MasterTrukController::class, 'index'])->name('admin.mastertruk.index');
Route::get('/master-truk/create', [MasterTrukController::class, 'create'])->name('admin.mastertruk.create');
Route::post('/master-truk', [MasterTrukController::class, 'store'])->name('admin.mastertruk.store');
Route::get('/master-truk/{masterTruk}/edit', [MasterTrukController::class, 'edit'])->name('admin.mastertruk.edit');
Route::put('/master-truk/{masterTruk}', [MasterTrukController::class, 'update'])->name('admin.mastertruk.update');
Route::delete('/master-truk/{masterTruk}', [MasterTrukController::class, 'destroy'])->name('admin.mastertruk.destroy');

use App\Http\Controllers\Admin\SparepartController;

Route::middleware(['auth'])->group(function () {
    Route::get('/sparepart', [SparepartController::class, 'index'])->name('admin.sparepart.index');
    Route::get('/sparepart/create', [SparepartController::class, 'create'])->name('admin.sparepart.create');
    Route::post('/sparepart', [SparepartController::class, 'store'])->name('admin.sparepart.store');
    Route::get('/sparepart/{sparepart}/edit', [SparepartController::class, 'edit'])->name('admin.sparepart.edit');
    Route::put('/sparepart/{sparepart}', [SparepartController::class, 'update'])->name('admin.sparepart.update');
    Route::delete('/sparepart/{sparepart}', [SparepartController::class, 'destroy'])->name('admin.sparepart.destroy');
});


    use App\Http\Controllers\Admin\PembelianSparepartController;
    Route::middleware(['auth'])->group(function () {
    Route::get('/pembelian', [PembelianSparepartController::class, 'index'])->name('admin.pembelian.index');
    Route::get('/pembelian/create', [PembelianSparepartController::class, 'create'])->name('admin.pembelian.create');
    Route::get('/pembelian/edit', [PembelianSparepartController::class, 'edit'])->name('admin.pembelian.edit');
    Route::post('/pembelian', [PembelianSparepartController::class, 'store'])->name('admin.pembelian.store');
    Route::delete('/pembelian/{pembelian}', [PembelianSparepartController::class, 'destroy'])->name('admin.pembelian.destroy');
});



use App\Http\Controllers\Admin\MaintenanceController;
Route::middleware(['auth'])->group(function () {
    Route::get('/maintenance', [MaintenanceController::class, 'index'])->name('admin.maintenance.index');
    Route::get('/maintenance/create', [MaintenanceController::class, 'create'])->name('admin.maintenance.create');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('admin.maintenance.store');
    Route::get('/maintenance/{id}/edit', [MaintenanceController::class, 'edit'])->name('admin.maintenance.edit');
    Route::put('/maintenance/{id}', [MaintenanceController::class, 'update'])->name('admin.maintenance.update');
    Route::delete('/maintenance/{id}', [MaintenanceController::class, 'destroy'])->name('admin.maintenance.destroy');
    Route::get('/maintenance/export/pdf', [MaintenanceController::class, 'exportPDF'])->name('admin.maintenance.export');
});

use App\Http\Controllers\Admin\TripBerangkatController;
use App\Http\Controllers\Admin\TripPulangController;

// Trip Berangkat
Route::get('/tripberangkat', [TripBerangkatController::class, 'index'])->name('admin.tripberangkat.index');
Route::get('/tripberangkat/create', [TripBerangkatController::class, 'create'])->name('admin.tripberangkat.create');
Route::post('/tripberangkat', [TripBerangkatController::class, 'store'])->name('admin.tripberangkat.store');
Route::get('/tripberangkat/{tripBerangkat}/edit', [TripBerangkatController::class, 'edit'])->name('admin.tripberangkat.edit');
Route::put('/tripberangkat/{tripBerangkat}', [TripBerangkatController::class, 'update'])->name('admin.tripberangkat.update');
Route::delete('/tripberangkat/{tripBerangkat}', [TripBerangkatController::class, 'destroy'])->name('admin.tripberangkat.destroy');

// Trip Pulang
Route::get('/trip-pulang', [TripPulangController::class, 'index'])->name('trip-pulang.index');
Route::get('/trip-pulang/create', [TripPulangController::class, 'create'])->name('trip-pulang.create');
Route::post('/trip-pulang', [TripPulangController::class, 'store'])->name('trip-pulang.store');
Route::get('/trip-pulang/{tripPulang}/edit', [TripPulangController::class, 'edit'])->name('trip-pulang.edit');
Route::put('/trip-pulang/{tripPulang}', [TripPulangController::class, 'update'])->name('trip-pulang.update');
Route::delete('/trip-pulang/{tripPulang}', [TripPulangController::class, 'destroy'])->name('trip-pulang.destroy');
Route::get('trip-pulang/export', [TripPulangController::class, 'export'])->name('trippulang.export');


// Export PDF Trip Berangkat & Pulang (Admin)
Route::get('/admin/tripberangkat/export', [App\Http\Controllers\Admin\TripBerangkatController::class, 'export'])->name('admin.tripberangkat.export');
Route::get('/admin/trippulang/export', [App\Http\Controllers\Admin\TripPulangController::class, 'export'])->name('admin.trippulang.export');


use App\Http\Controllers\Admin\GajiSopirController;

Route::prefix('admin')->group(function () {
    Route::get('/gaji-sopir', [GajiSopirController::class, 'index'])->name('admin.gaji-sopir.index');
    Route::get('/gaji-sopir/export', [GajiSopirController::class, 'export'])->name('admin.gaji-sopir.export');
});


use App\Http\Controllers\Admin\InvoiceController;

Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.invoice.index');
Route::get('/invoice/export', [InvoiceController::class, 'export'])->name('admin.invoice.export');




Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/nota-pengeluaran', [NotaPengeluaranController::class, 'index'])->name('notapengeluaran.index');
    Route::get('/nota-pengeluaran/export', [NotaPengeluaranController::class, 'export'])->name('notapengeluaran.export');
});

Route::get('/laporan-kerusakan', [LaporanKerusakanController::class, 'index'])->name('admin.laporankerusakan.index');
Route::get('/laporan-kerusakan/export', [LaporanKerusakanController::class, 'export'])->name('admin.laporankerusakan.export');







// routes/web.php
Route::prefix('manajer')->middleware(['auth'])->group(function () {
    Route::get('/laporan-kerusakan', [ManajerKerusakanController::class, 'index'])->name('manajer.kerusakan.index');
    Route::get('/laporan-kerusakan/{id}', [ManajerKerusakanController::class, 'show'])->name('manajer.kerusakan.show');
    Route::post('/laporan-kerusakan/{id}/status', [ManajerKerusakanController::class, 'updateStatus'])->name('manajer.kerusakan.updateStatus');
    Route::get('/laporan-kerusakan/export/pdf', [ManajerKerusakanController::class, 'export'])->name('manajer.kerusakan.export');
});

use App\Http\Controllers\Manajer\MaintenanceController as ManajerMaintenanceController;

Route::prefix('manajer')->middleware(['auth'])->name('manajer.')->group(function () {
    Route::get('/maintenance', [ManajerMaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create', [ManajerMaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [ManajerMaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance/{id}/edit', [ManajerMaintenanceController::class, 'edit'])->name('maintenance.edit');
    Route::put('/maintenance/{id}', [ManajerMaintenanceController::class, 'update'])->name('maintenance.update');
    Route::delete('/maintenance/{id}', [ManajerMaintenanceController::class, 'destroy'])->name('maintenance.destroy');
});


use App\Http\Controllers\Manajer\NotaPengeluaranController as ManajerNotaPengeluaranController;

Route::prefix('manajer')->middleware(['auth'])->name('manajer.')->group(function () {
    Route::get('/nota-pengeluaran', [ManajerNotaPengeluaranController::class, 'index'])->name('nota-pengeluaran.index');
    Route::get('/nota-pengeluaran/create', [ManajerNotaPengeluaranController::class, 'create'])->name('nota-pengeluaran.create');
    Route::post('/nota-pengeluaran', [ManajerNotaPengeluaranController::class, 'store'])->name('nota-pengeluaran.store');
    Route::get('/nota-pengeluaran/{id}/edit', [ManajerNotaPengeluaranController::class, 'edit'])->name('nota-pengeluaran.edit');
    Route::put('/nota-pengeluaran/{id}', [ManajerNotaPengeluaranController::class, 'update'])->name('nota-pengeluaran.update');
    Route::delete('/nota-pengeluaran/{id}', [ManajerNotaPengeluaranController::class, 'destroy'])->name('nota-pengeluaran.destroy');
});


use App\Http\Controllers\Owner\RitaseOwnerController;


    use App\Http\Controllers\Owner\NotaBbmOwnerController;



    use App\Http\Controllers\Owner\KerusakanOwnerController;

Route::get('/kerusakan-owner', [KerusakanOwnerController::class, 'index'])
    ->middleware(['auth', 'owner'])
    ->name('owner.kerusakan.index');

    use App\Http\Controllers\Owner\KeuanganOwnerController;

Route::get('/keuangan-owner', [KeuanganOwnerController::class, 'index'])
    ->middleware(['auth', 'owner'])
    ->name('owner.keuangan.index');

    use App\Http\Controllers\Manajer\ManajerKerusakanController;

Route::prefix('manajer')->middleware(['auth'])->name('manajer.')->group(function () {
    Route::get('/laporan-kerusakan', [ManajerKerusakanController::class, 'index'])->name('kerusakan.index');
    Route::put('/laporan-kerusakan/{id}/setujui', [ManajerKerusakanController::class, 'setujui'])->name('kerusakan.setujui');
    Route::put('/laporan-kerusakan/{id}/tolak', [ManajerKerusakanController::class, 'tolak'])->name('kerusakan.tolak');
});


use App\Http\Controllers\Manajer\NotaHaulingController as ManajerNotaHaulingController;


Route::get('/manajer/nota-hauling', [NotaHaulingController::class, 'index'])
    ->middleware(['auth'])
    ->name('manajer.nota-hauling.index');


    use App\Http\Controllers\Manajer\JadwalOperasionalController;
    Route::prefix('manajer')
    ->name('manajer.')
    ->middleware(['auth'])
    ->group(function () {
        Route::resource('jadwal', JadwalOperasionalController::class);
    });

    Route::get('maintenance/from-laporan/{id}', [MaintenanceController::class, 'createFromLaporan'])->name('manajer.maintenance.fromLaporan');
   


use App\Http\Controllers\Sopir\TripBerangkatController as SopirTripBerangkatController;

   
// Halaman form tambah trip
Route::get('sopir/trip-berangkat//{id}/create', [SopirTripBerangkatController::class, 'create'])->name('sopir.trip-berangkat.create');

// Simpan data trip
Route::post('sopir/trip-berangkat/{id}/store', [SopirTripBerangkatController::class, 'store'])->name('sopir.trip-berangkat.store');

// Tampilkan daftar trip
Route::get('/trip-berangkat', [SopirTripBerangkatController::class, 'index'])->name('sopir.trip-berangkat.index');

// Kalau perlu edit dan delete manual juga
Route::get('trip-berangkat/{id}/edit', [SopirTripBerangkatController::class, 'edit'])->name('sopir.trip-berangkat.edit');
Route::post('trip-berangkat/{id}/update', [SopirTripBerangkatController::class, 'update'])->name('sopir.trip-berangkat.update');
Route::post('trip-berangkat/{id}/delete', [SopirTripBerangkatController::class, 'destroy'])->name('sopir.trip-berangkat.destroy');
    
// Untuk Trip Pulang (Form dan Simpan)


Route::prefix('sopir')->middleware(['auth'])->group(function () {
    Route::get('/trip-pulang', [\App\Http\Controllers\Sopir\TripPulangController::class, 'index'])->name('sopir.trip-pulang.index');
    Route::get('/trip-pulang/{id}/form', [\App\Http\Controllers\Sopir\TripPulangController::class, 'form'])->name('sopir.trip-pulang.form');
  
  Route::post('/trip-pulang/{id}/submit', [\App\Http\Controllers\Sopir\TripPulangController::class, 'submit'])->name('sopir.trip-pulang.submit');
  Route::post('trip-pulang/{id}/store', [\App\Http\Controllers\Sopir\TripPulangController::class, 'store'])->name('sopir.trip-pulang.store');
});

Route::middleware(['auth'])->prefix('sopir')->name('sopir.')->group(function () {
    Route::get('ritase', [\App\Http\Controllers\Sopir\RitaseController::class, 'index'])->name('ritase.index');
    Route::get('ritase/create', [\App\Http\Controllers\Sopir\RitaseController::class, 'create'])->name('ritase.create');
    Route::post('ritase', [\App\Http\Controllers\Sopir\RitaseController::class, 'store'])->name('ritase.store');
});


Route::prefix('owner')->middleware(['auth'])->group(function () {
    Route::get('/ritase', [RitaseOwnerController::class, 'index'])->name('owner.ritase.index');
});

use App\Http\Controllers\Owner\MaintenanceOwnerController;

Route::get('/maintenance-owner', [MaintenanceOwnerController::class, 'index'])
    ->middleware(['auth'])
    ->name('owner.maintenance.index');



    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::resource('mastertruk', MasterTrukController::class);
    });


    use App\Http\Controllers\Admin\SopirController;

    Route::middleware(['auth'])->group(function () {
        Route::get('/sopir', [SopirController::class, 'index'])->name('admin.sopir.index');
        Route::get('/sopir/create', [SopirController::class, 'create'])->name('admin.sopir.create');
        Route::post('/sopir', [SopirController::class, 'store'])->name('admin.sopir.store');
        Route::get('/sopir/{sopir}/edit', [SopirController::class, 'edit'])->name('admin.sopir.edit');
        Route::put('/sopir/{sopir}', [SopirController::class, 'update'])->name('admin.sopir.update');
        Route::delete('/sopir/{sopir}', [SopirController::class, 'destroy'])->name('admin.sopir.destroy');
    });
    
    use App\Http\Controllers\Admin\KlienController;

    Route::middleware(['auth'])->group(function () {
        // Tampilkan daftar klien
        Route::get('/klien', [KlienController::class, 'index'])->name('admin.klien.index');
    
        // Form tambah klien
        Route::get('/klien/create', [KlienController::class, 'create'])->name('admin.klien.create');
    
        // Simpan klien baru
        Route::post('/klien', [KlienController::class, 'store'])->name('admin.klien.store');
    
        // Form edit klien
        Route::get('/klien/{klien}/edit', [KlienController::class, 'edit'])->name('admin.klien.edit');
    
        // Simpan perubahan klien
        Route::put('/klien/{klien}', [KlienController::class, 'update'])->name('admin.klien.update');
    
        // Hapus klien
        Route::delete('/klien/{klien}', [KlienController::class, 'destroy'])->name('admin.klien.destroy');
    });

    use App\Http\Controllers\Admin\LaporanKeuanganController;

    Route::middleware(['auth'])->group(function () {
        Route::get('/laporan-keuangan', [LaporanKeuanganController::class, 'index'])
            ->name('admin.laporan_keuangan.index');
    
        Route::get('/laporan-keuangan/export', [LaporanKeuanganController::class, 'exportPdf'])
            ->name('admin.laporan_keuangan.export');
    });

    use App\Http\Controllers\Admin\NotaHaulingController;

Route::middleware(['auth'])->group(function () {
    Route::get('notahauling', [NotaHaulingController::class, 'index'])->name('admin.nota-hauling.index');
    Route::get('notahauling/export', [NotaHaulingController::class, 'exportPdf'])->name('admin.nota-hauling.export');
});


    
   
use App\Http\Controllers\Admin\NotaPengeluaranController;

Route::middleware(['auth'])->group(function () {
    // Tampilkan semua nota pengeluaran
    Route::get('nota-pengeluaran', [NotaPengeluaranController::class, 'index'])
        ->name('admin.notapengeluaran.index');

    // Form tambah nota pengeluaran
    Route::get('nota-pengeluaran/create', [NotaPengeluaranController::class, 'create'])
        ->name('admin.notapengeluaran.create');

    // Simpan nota pengeluaran baru
    Route::post('nota-pengeluaran', [NotaPengeluaranController::class, 'store'])
        ->name('admin.notapengeluaran.store');

    // Form edit nota pengeluaran
    Route::get('nota-pengeluaran/{notaPengeluaran}/edit', [NotaPengeluaranController::class, 'edit'])
        ->name('admin.notapengeluaran.edit');

    // Update nota pengeluaran
    Route::put('nota-pengeluaran/{notaPengeluaran}', [NotaPengeluaranController::class, 'update'])
        ->name('admin.notapengeluaran.update');

    // Hapus nota pengeluaran
    Route::delete('nota-pengeluaran/{notaPengeluaran}', [NotaPengeluaranController::class, 'destroy'])
        ->name('admin.notapengeluaran.destroy');

    // Export PDF / filter
    Route::get('nota-pengeluaran-export', [NotaPengeluaranController::class, 'export'])
        ->name('admin.notapengeluaran.export');
});

    
    
//Sopir//

use App\Http\Controllers\Sopir\LaporanNotaHaulingController as SopirNotaHaulingController;

Route::middleware(['auth'])->group(function () {
    Route::get('/laporan-nota-hauling', [SopirNotaHaulingController::class, 'index'])->name('sopir.laporan-nota-hauling.index');
    Route::get('/laporan-nota-hauling/create', [SopirNotaHaulingController::class, 'create'])->name('sopir.laporan-nota-hauling.create');
    Route::post('/laporan-nota-hauling', [SopirNotaHaulingController::class, 'store'])->name('sopir.laporan-nota-hauling.store');
    Route::get('/laporan-nota-hauling/{id}/edit', [SopirNotaHaulingController::class, 'edit'])->name('sopir.laporan-nota-hauling.edit');
    Route::put('/laporan-nota-hauling/{id}', [SopirNotaHaulingController::class, 'update'])->name('sopir.laporan-nota-hauling.update');
    Route::delete('/laporan-nota-hauling/{id}', [SopirNotaHaulingController::class, 'destroy'])->name('sopir.laporan-nota-hauling.destroy');
});
    


use App\Http\Controllers\Sopir\LaporanNotaPengeluaranController;

Route::middleware(['auth'])->group(function () {
    Route::get('/nota-pengeluaran', [LaporanNotaPengeluaranController::class, 'index'])
        ->name('sopir.nota-pengeluaran.index');
    Route::get('/nota-pengeluaran/create', [LaporanNotaPengeluaranController::class, 'create'])
        ->name('sopir.nota-pengeluaran.create');
    Route::post('/nota-pengeluaran', [LaporanNotaPengeluaranController::class, 'store'])
        ->name('sopir.nota-pengeluaran.store');
    Route::get('/nota-pengeluaran/{id}/edit', [LaporanNotaPengeluaranController::class, 'edit'])
        ->name('sopir.nota-pengeluaran.edit');
    Route::put('/nota-pengeluaran/{id}', [LaporanNotaPengeluaranController::class, 'update'])
        ->name('sopir.nota-pengeluaran.update');
    Route::delete('/nota-pengeluaran/{id}', [LaporanNotaPengeluaranController::class, 'destroy'])
        ->name('sopir.nota-pengeluaran.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::post('jadwal/{jadwal}/mulai', [JadwalSopirController::class, 'mulaiPerjalanan'])->name('jadwal.mulai');
    Route::post('jadwal/{jadwal}/selesai', [JadwalSopirController::class, 'selesaiPerjalanan'])->name('jadwal.selesai');
    Route::post('jadwal/{jadwal}/batal', [JadwalSopirController::class, 'batalkanPerjalanan'])->name('jadwal.batal');
});


use App\Http\Controllers\Sopir\RiwayatTripController;

Route::middleware(['auth'])->prefix('sopir')->group(function () {
    Route::get('riwayat-trip', [RiwayatTripController::class, 'index'])->name('sopir.riwayat-trip.index');
});

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
       