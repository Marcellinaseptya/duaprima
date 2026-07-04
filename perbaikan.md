# Catatan Error dan Perbaikan (Bug Log & Fixes)

Dokumen ini mencatat semua error yang terjadi selama pengembangan/perbaikan proyek, beserta langkah solusi yang diimplementasikan.

## 1. Error Migrasi (Drop Column `truk_id`)

**Tanggal/Waktu:** 2 Juli 2026

**Pesan Error:**
`SQLSTATE[42000]: Syntax error or access violation: 1091 Can't DROP COLUMN 'truk_id'; check that it exists`

**Penyebab:**
- Perintah `dropColumn('truk_id')` dijalankan langsung di migrasi tanpa menghapus relasi Foreign Key-nya terlebih dahulu (di MySQL wajib drop constraint sebelum drop column).
- Kemungkinan lain adalah kolom sudah terhapus secara sepihak atau terjadi asinkronisasi state database sehingga muncul pesan error 1091.

**Solusi / Perbaikan:**
- Mengubah file migrasi `2025_08_27_001347_drop_truk_id_from_maintenance_table.php`.
- Menambahkan pengecekan `Schema::hasColumn('maintenance', 'truk_id')` agar baris perbaikan hanya dieksekusi bila kolom memang masih ada.
- Menambahkan perintah `$table->dropForeign(['truk_id'])` sebelum perintah `$table->dropColumn('truk_id')`.

## 2. Error Database Seeder (Class Not Found)

**Tanggal/Waktu:** 2 Juli 2026

**Pesan Error:**
`ReflectionException::("Class "DatabaseSeeder" does not exist")` saat menjalankan `php artisan db:seed`.

**Penyebab:**
- File `DatabaseSeeder.php` ternyata memiliki nama class yang salah di dalamnya (tertulis `class SparepartSeeder extends Seeder` alih-alih `class DatabaseSeeder`). Akibatnya, Laravel tidak bisa menemukan class `DatabaseSeeder` yang merupakan *entry point* default untuk seeding.

**Solusi / Perbaikan:**
- Mengubah nama class di dalam file `database/seeders/DatabaseSeeder.php` menjadi `DatabaseSeeder`.
- Memindahkan logika *seeding* dari `DatabaseSeeder` ke file aslinya atau memanggil class seeder lain menggunakan `$this->call([...])`.

## 3. Error Seeder (Unknown Column `name`)

**Tanggal/Waktu:** 2 Juli 2026

**Pesan Error:**
`SQLSTATE[42S22]: Column not found: 1054 Unknown column 'name' in 'field list'` (saat menjalankan `php artisan db:seed`).

**Penyebab:**
- Pada tabel `users` di database yang berjalan, kolom nama pengguna disebut dengan `nama`, sedangkan di file `UserSeeder.php` (dan migrasi `create_users_table`) menggunakan `name`. Hal ini menimbulkan ketidakcocokan (mismatch) saat seeder mencoba meng-insert data menggunakan field `name`.

**Solusi / Perbaikan:**
- Mengubah *key* array pada `UserSeeder.php` dari `name` menjadi `nama`.
- Mengubah penamaan field pada file migrasi `2025_07_23_055844_create_users_table.php` dari `$table->string('name');` menjadi `$table->string('nama');` agar konsisten jika suatu saat dilakukan migrasi ulang (fresh).

## 4. Error Seeder (Duplicate Entry)

**Tanggal/Waktu:** 2 Juli 2026

**Pesan Error:**
`SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry 'admin@gmail.com' for key 'users_email_unique'` (saat menjalankan `php artisan db:seed`).

**Penyebab:**
- Perintah `php artisan db:seed` dijalankan pada database yang sudah terisi data `admin@gmail.com` dari seeding atau entri sebelumnya. Fungsi `User::create()` di Laravel secara mentah mencoba menyisipkan data baru yang memicu penolakan karena kolom `email` bersifat `unique`.

**Solusi / Perbaikan:**
- Mengganti fungsi `User::create()` menjadi `User::updateOrCreate()` pada `UserSeeder.php` agar sistem melakukan update jika data sudah ada, bukan mencoba membuat (insert) yang baru sehingga seeder menjadi bersifat *idempotent* (kebal untuk dijalankan berulang kali).

## 5. Error Seeder (Table `kategoris` doesn't exist)

**Tanggal/Waktu:** 2 Juli 2026

**Pesan Error:**
`SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db_truk_backup.kategoris' doesn't exist` (saat menjalankan `php artisan db:seed`).

**Penyebab:**
- File `DatabaseSeeder.php` memanggil class `KategoriSeeder`, `TahunSeeder`, dan `DokumentasiSeeder`. Ketiga class ini kemungkinan besar merupakan sisa-sisa file dari proyek lama (seperti E-Library) yang ikut terkopi ke dalam proyek sistem manajemen truk ini. Karena tabel-tabel tersebut memang tidak ada di proyek ini, seeder pun gagal.

**Solusi / Perbaikan:**
- Menghapus pemanggilan `KategoriSeeder::class`, `TahunSeeder::class`, dan `DokumentasiSeeder::class` dari file `DatabaseSeeder.php`. Fokus pada pemanggilan *seeder* yang relevan dengan aplikasi ini, yaitu `RoleSeeder`, `UserSeeder`, `MasterMerkSeeder`, dan `SparepartSeeder`.

## 6. Fatal Error (ReflectionException) karena File 0 Bytes

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`ReflectionException: Class "App\Http\Controllers\Admin\GajiSopirController" does not exist` saat mengakses rute aplikasi atau menjalankan `php artisan route:list`.

**Penyebab:**
- Beberapa file inti aplikasi (`GajiSopirController.php`, `NotaController.php`, `RedirectIfAuthenticated.php`, dan `Nota.php`) rusak dan berukuran 0 bytes. Hal ini membuat PHP tidak dapat mengenali class yang berada di dalamnya.

**Solusi / Perbaikan:**
- Mengembalikan struktur *class* dan *namespace* bawaan pada file-file tersebut agar dapat dibaca oleh sistem tanpa error, sesuai dengan fungsi dasarnya.

## 7. Layar Blank / Error pada File View (Blade) Kosong

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
Tidak ada error spesifik, hanya menampilkan layar putih kosong (*blank page*) atau `Route ... not defined` jika di-load.

**Penyebab:**
- Beberapa file tampilan (*view*) berukuran 0 bytes, seperti `transaksi_keuangan.blade.php`, `admin/jadwal-operasional/create.blade.php`, `admin/maintenance/export.blade.php`, dan `admin/tripberangkat/create` (tanpa ekstensi).

**Solusi / Perbaikan:**
- Mengisi file-file yang kosong dengan struktur *layout* HTML standar bawaan sistem (`@extends('layout.main')`).
- Mengubah nama file `create` menjadi `create.blade.php` pada folder `tripberangkat`.

## 8. Root Route (`/`) Menampilkan 404

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`404 Not Found` saat mengakses URL dasar aplikasi (`http://localhost:8000/`).

**Penyebab:**
- Tidak ada pengaturan rute untuk halaman utama (`/`) di dalam file `routes/web.php`.

**Solusi / Perbaikan:**
- Menambahkan rute `/` yang secara otomatis mengalihkan (redirect) pengguna ke rute `login`.

## 9. Error Konflik Namespace di Controller

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Cannot declare class App\Http\Controllers\Admin\RitaseController, because the name is already in use`.

**Penyebab:**
- File `app/Http/Controllers/Sopir/RitaseController.php` keliru menuliskan namespacenya menjadi `namespace App\Http\Controllers\Admin;`.

**Solusi / Perbaikan:**
- Memperbaiki namespace tersebut menjadi `namespace App\Http\Controllers\Sopir;` dan menyesuaikan rujukan view menjadi `sopir.ritase.index`.

## 10. Gagal Login (Verifikasi Password Salah)

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Email atau password salah` ketika mencoba masuk ke halaman login meskipun data seeder sudah masuk.

**Penyebab:**
- Logika validasi di `LoginController.php` menggunakan pengecekan string biasa (`$user->password === $request->password`) untuk membandingkan password.
- Padahal password di database disimpan menggunakan enkripsi *hash* (bcrypt), sehingga teks biasa tidak akan pernah cocok.

**Solusi / Perbaikan:**
- Mengganti kode pengecekan manual tersebut dengan metode bawaan Laravel: `\Illuminate\Support\Facades\Hash::check($request->password, $user->password)`.

## 11. Role Login Gagal Terbaca (Akses Terbatas ke Sopir)

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
Akun dengan role 'admin' atau 'owner' salah diarahkan ke dashboard 'sopir'.

**Penyebab:**
- `UserSeeder.php` tidak menyisipkan data `role` saat membuat user (misal `admin@gmail.com`). Akibatnya, nilai kolom `role` di database otomatis mengikuti nilai default dari migrasi, yaitu `sopir`.

**Solusi / Perbaikan:**
- Menambahkan field `'role' => 'admin'` dsb pada setiap array `updateOrCreate` di `UserSeeder.php`, lalu menjalankan ulang perintah `php artisan db:seed`.

## 12. Internal Server Error saat Export Trip Berangkat

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Internal Server Error: Undefined variable $trips` saat menekan tombol Export Laporan di Trip Berangkat.

**Penyebab:**
- Controller `TripBerangkatController` mengirim data ke view `export.blade.php` dengan nama variabel `$jadwals`, namun view memanggilnya dengan variabel `$trips`. 
- Properti relasi di dalam file view juga tidak sesuai dengan struktur relasi `JadwalOperasional`.

**Solusi / Perbaikan:**
- Mengubah perulangan di view `export.blade.php` menjadi `@foreach($jadwals as $trip)` dan menyesuaikan hierarki pemanggilan relasi tabelnya (misal: dari `$trip->truk` menjadi `$trip->mastertruk`, dan seterusnya) sesuai standar data model saat ini.

## 13. Unknown Column `tanggal_pulang` pada Fitur Laporan

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`SQLSTATE[42S22]: Column not found: 1054 Unknown column 'tanggal_pulang' in 'where clause'` saat mengakses menu Laporan Keuangan, Ritase, dsb.

**Penyebab:**
- Beberapa file *controller* (`LaporanKeuanganController`, `RitaseController`, `TripPulangController`) dan *view* mencoba memfilter atau mencetak data menggunakan kolom bernama `tanggal_pulang`.
- Padahal, tabel `trip_pulang` di database tidak memiliki kolom tersebut; melainkan menggunakan `waktu_selesai`.

**Solusi / Perbaikan:**
- Melakukan penyesuaian (replace) secara menyeluruh pada source code: Mengubah referensi `tanggal_pulang` menjadi `waktu_selesai` agar sinkron dengan struktur database asli yang ada, tanpa mengubah logika filter/tampilannya.

## 14. Unknown Column `tanggal` pada Query PembelianSparepart

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`SQLSTATE[42S22]: Column not found: 1054 Unknown column 'tanggal' in 'where clause'` pada filter halaman Laporan Keuangan.

**Penyebab:**
- Saat melakukan filter data berdasarkan rentang waktu, *controller* `LaporanKeuanganController` mencoba mencari data sparepart dengan kondisi `whereBetween('tanggal', ...)`. 
- Namun di dalam tabel `pembelian_sparepart`, nama kolom yang merepresentasikan tanggal adalah `tanggal_pembelian` (bukan `tanggal`).

**Solusi / Perbaikan:**
- Mengganti referensi kolom dari `tanggal` menjadi `tanggal_pembelian` pada bagian query filter `$sparepartQuery` di dalam file `LaporanKeuanganController.php`.

## 15. Call to undefined method `exportPdf()` pada Nota Hauling

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Call to undefined method App\Http\Controllers\Admin\LaporanNotaHaulingController::exportPdf()` saat mengeklik Export di halaman Nota Hauling.

**Penyebab:**
- File rute `routes/web.php` memanggil method `exportPdf` dari `LaporanNotaHaulingController` saat *endpoint* `/notahauling/export` diakses.
- Kenyataannya, di dalam controller tersebut, method yang menangani fungsi ekspor PDF bernama `export()` (bukan `exportPdf`).

**Solusi / Perbaikan:**
- Mengubah nama pemanggilan method di `routes/web.php` dari `exportPdf` menjadi `export` agar cocok dengan fungsi yang sudah tersedia di dalam controller.

## 16. Undefined variable `$notaHauling` pada Export PDF

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`ErrorException: Undefined variable $notaHauling` saat membuka halaman Export PDF Nota Hauling.

**Penyebab:**
- `LaporanNotaHaulingController` mengirimkan data ke tampilan (`view`) PDF menggunakan nama variabel `$notas`.
- Namun, di dalam file tampilan `resources/views/admin/nota-hauling/export.blade.php`, perulangan data mencoba menggunakan variabel bernama `$notaHauling` (`@forelse($notaHauling as $nota)`).

**Solusi / Perbaikan:**
- Mengubah perulangan di file tampilan `export.blade.php` menjadi `@forelse($notas as $nota)` agar serasi dengan data yang diumpankan oleh controller.
- Sekalian mengubah relasi nama pengguna dari `$nota->sopir->user->name` menjadi `$nota->sopir->user->nama` sesuai dengan struktur tabel `users` yang menggunakan kolom `nama`.

## 17. Call to undefined method `export()` pada Laporan Kerusakan

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Call to undefined method App\Http\Controllers\Admin\LaporanKerusakanController::export()` saat mencoba mengekspor laporan kerusakan.

**Penyebab:**
- Kebalikan dari kasus Nota Hauling, pada fitur ini file rute (`routes/web.php`) memanggil fungsi `export`.
- Padahal, fungsi untuk mengekspor PDF di dalam class `LaporanKerusakanController` dinamai `exportPdf()`.

**Solusi / Perbaikan:**
- Memperbaiki deklarasi rute di `routes/web.php` dari `export` menjadi `exportPdf` agar sesuai dengan nama fungsi aktual yang ada di dalam *controller* tersebut.

## 18. Undefined variable `$tanggalCetak` dan Error Kolom di Export Laporan Kerusakan

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Undefined variable $tanggalCetak` dan berpotensi error `Property [tanggal_laporan] does not exist on this collection instance` saat mencetak PDF Laporan Kerusakan.

**Penyebab:**
- File tampilan PDF `resources/views/admin/laporan-kerusakan/export.blade.php` meminta variabel `$tanggalCetak` untuk dicetak di pojok kanan atas, namun `LaporanKerusakanController` lupa mengirimkannya.
- Desain PDF juga mencoba memanggil nama kolom yang salah dari database: `tanggal_laporan` (seharusnya `tanggal`), `deskripsi` (seharusnya `deskripsi_kerusakan`), relasi `truk` (seharusnya `mastertruk`), dan relasi `sopir->nama` (seharusnya `sopir->user->nama`).

**Solusi / Perbaikan:**
- Mengisi nilai `$tanggalCetak = \Carbon\Carbon::now()->translatedFormat('d F Y');` di dalam Controller dan melemparkannya menggunakan `compact('laporans', 'tanggalCetak')`.
- Memperbaiki seluruh nama pemanggilan field dan relasi di dalam `export.blade.php` agar sama dengan stuktur asli tabel `laporan_kerusakan`.

## 19. Undefined Variable `$kliens` pada Cetak Invoice Ritase

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Undefined variable $kliens` saat mencoba mengekspor/mencetak Invoice Ritase ke PDF.

**Penyebab:**
- Terjadi *copy-paste error* dari *developer* sebelumnya. File `export.blade.php` milik Invoice Ritase ternyata berisi *layout* yang sama persis dengan `index.blade.php` (termasuk tombol, filter tanggal, dan *dropdown* pilihan Klien).
- Karena ini aslinya adalah file untuk merender PDF murni (yang seharusnya cuma tabel data tanpa tombol), *controller* tidak mengirimkan data daftar `$kliens` untuk dropdown tersebut, yang akhirnya memicu *error*.
- Pemanggilan variabel nama sopir juga salah (masih `$ritase->tripBerangkat->sopir->nama` yang seharusnya `$ritase->tripBerangkat->sopir->user->nama`).

**Solusi / Perbaikan:**
- Membersihkan file `resources/views/admin/invoice/export.blade.php` dengan cara membuang seluruh struktur HTML yang tidak relevan (form pencarian, filter dropdown, layout menu navigasi) dan hanya menyisakan kode tabel murni berserta kop (header) perusahaan untuk di-generate sebagai dokumen PDF.
- Memperbaiki variabel pemanggilan relasi datanya (seperti nama sopir) agar bisa dirender dengan sempurna tanpa error ke dalam bentuk tabel.

## 20. Undefined Method `edit()` pada Master Truk

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Call to undefined method App\Http\Controllers\Admin\MasterTrukController::edit()` saat mengklik tombol Edit pada halaman Master Truk.

**Penyebab:**
- File rute dideklarasikan menggunakan `Route::resource('master-truk', MasterTrukController::class)` yang mana secara otomatis mencari fungsi-fungsi standar CRUD seperti `index`, `create`, `store`, `show`, `edit`, `update`, dan `destroy`.
- Sayangnya, sang *developer* sebelumnya lupa menuliskan fungsi `edit()`, `update()`, dan `destroy()` di dalam file `MasterTrukController.php`!

**Solusi / Perbaikan:**
- Menulis dan menambahkan ulang fungsi `edit()`, `update()`, dan `destroy()` ke dalam `MasterTrukController.php` beserta segala logika validasi input yang dibutuhkan saat menyimpan ulang (*update*) data truk maupun menghapusnya.

## 21. Route `admin.master-truk.update` Not Defined pada Form Edit Truk

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Route [admin.master-truk.update] not defined.` saat mencoba membuka halaman edit Master Truk.

**Penyebab:**
- Karena dideklarasikan menggunakan fungsi `Route::resource('master-truk', ...)->names('admin.mastertruk')`, nama rute bawaan laravel yang ter-*generate* seharusnya adalah `admin.mastertruk.update` (tanpa tanda strip/hyphen `-`).
- Namun di dalam file `resources/views/admin/mastertruk/edit.blade.php`, aksi tombol simpan dipanggil dengan nama rute `admin.master-truk.update` dan tombol kembali dipanggil dengan `admin.master-truk.index`.
- Lebih parahnya lagi, di file *blade* tersebut seluruh kolom *input* ditaruh **di luar** *tag* `<form>`, dan file tersebut mencoba meng-*include* file `form.blade.php` yang rupanya sudah terhapus atau memang tidak pernah ada!

**Solusi / Perbaikan:**
- Merombak ulang seluruh isi file `edit.blade.php` agar tag `<form>` menyelimuti semua kolom input.
- Mengganti nama *route* dari yang sebelumnya salah menjadi nama rute yang benar, yaitu `admin.mastertruk.update` dan `admin.mastertruk.index`.

## 22. Undefined Method `edit()` pada Manajemen Sparepart

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Call to undefined method App\Http\Controllers\Admin\SparepartController::edit()` saat mengklik tombol Edit pada halaman Data Sparepart.

**Penyebab:**
- Persis sama dengan kasus Master Truk sebelumnya. Rute telah dideklarasikan menggunakan fungsi `Route::resource('sparepart', ...)` di `routes/web.php`.
- Sayangnya, sang *developer* juga lupa menuliskan fungsi `edit()`, `update()`, dan `destroy()` di dalam `SparepartController.php`!
- Belum berhenti sampai di sana, file untuk merender halaman editnya (`resources/views/admin/sparepart/edit.blade.php`) ternyata **juga tidak pernah dibuat**.

**Solusi / Perbaikan:**
- Saya menambahkan fungsi `edit()`, `update()`, dan `destroy()` ke dalam `SparepartController.php` beserta validasinya.
- Membuat file `edit.blade.php` baru khusus untuk tabel Sparepart lengkap dengan form *input* untuk nama sparepart, stok, satuan, dan harga satuan.

## 23. Undefined Method `export()` pada Export Laporan Maintenance

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Call to undefined method App\Http\Controllers\Admin\MaintenanceController::export()` saat mencoba mengklik tombol Export PDF di halaman Data Maintenance.

**Penyebab:**
- Nama fungsi pencetakan PDF yang ditulis di dalam file *routing* (`routes/web.php` dan `routes/web1.php`) adalah `export`, sedangkan fungsi yang tertera di dalam `MaintenanceController.php` bernama `exportPDF`.
- *Controller* mencoba me-*load* file tampilan PDF yang bernama `admin.maintenance.export_pdf` namun file yang eksis sebenarnya bernama `export.blade.php`, dan itupun isinya nyaris kosong/rusak.
- Pemanggilan variabel relasi database pada view `index.blade.php` juga sangat kacau balau, misalnya `$m->truk->mastertruk->plat_nomor` padahal seharusnya `$m->mastertruk->plat_nomor`.

**Solusi / Perbaikan:**
- Mengganti pemanggilan fungsi `export` menjadi `exportPDF` di semua file rute web.
- Menyeragamkan nama pemanggilan view PDF pada *Controller* agar menunjuk langsung ke `admin.maintenance.export`.
- Menulis ulang seluruh isi file `resources/views/admin/maintenance/export.blade.php` dengan desain layout PDF tagihan (tabel murni tanpa *button*).
- Memperbaiki semua penamaan pemanggilan relasi database (*properties*) yang salah pada file `index.blade.php` agar tabel Maintenance bisa tampil dengan sempurna dan *real time*.

## 24. Route `sopir.trip-berangkat.index` Not Defined pada Dashboard Sopir

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Route [sopir.trip-berangkat.index] not defined.` saat Sopir mencoba melakukan *login* atau masuk ke *dashboard*.

**Penyebab:**
- Pada file navigasi sisi kiri (sidebar) khusus sopir (`sidebar-sopir.blade.php`), terdapat menu **Trip Berangkat** yang mengarah ke `route('sopir.trip-berangkat.index')`.
- Namun jika dicek pada file `routes/web.php` di dalam grup *prefix* `sopir`, *developer* ternyata kelupaan mendaftarkan rute utama untuk `index` tersebut! Yang ada hanyalah rute untuk `create` dan `store` saja.

**Solusi / Perbaikan:**
- Menambahkan rute `Route::get('/trip-berangkat', [SopirTripBerangkatController::class, 'index'])->name('trip-berangkat.index');` ke dalam `routes/web.php` di bawah grup hak akses Sopir sehingga menu di *sidebar* bisa terhubung dengan *controller*-nya.

## 25. Undefined Method `edit()` pada Laporan Nota Pengeluaran Sopir

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Call to undefined method App\Http\Controllers\Sopir\LaporanNotaPengeluaranController::edit()` saat sopir mencoba menekan tombol Edit pada Nota BBM & Parkir.

**Penyebab:**
- Sama dengan kelupaan fungsi-fungsi *resource* pada barisan bug sebelumnya, sang *developer* juga tidak menyertakan fungsi `edit()` dan `update()` di dalam `LaporanNotaPengeluaranController.php`.
- Jika form edit ini langsung dibuka, akan muncul *error* tambahan yaitu `Call to a member function format() on string` karena pemanggilan format tanggal (`$nota->tanggal->format('Y-m-d')`) di `edit.blade.php` tidak akan bekerja apabila tipe kolom `tanggal` belum di-*cast* sebagai tipe data 'date' di dalam model `NotaPengeluaran.php`.

**Solusi / Perbaikan:**
- Menambahkan fungsi `edit($id)` dan `update(Request $request, $id)` lengkap dengan fitur *upload/replace* file bukti nota yang baru pada `LaporanNotaPengeluaranController`.
- Menambahkan properti `$casts = ['tanggal' => 'date'];` ke dalam model `NotaPengeluaran.php` agar format tipe objek Carbon (seperti validasi format penanggalan *Y-m-d*) dapat bekerja mulus di sisi *Blade / View*.

## 26. View Not Found pada Tambah Laporan Nota Hauling Sopir

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`View [sopir.nota-hauling.create] not found.` saat mengklik tombol Tambah Nota Hauling pada halaman Sopir.

**Penyebab:**
- Di dalam `LaporanNotaHaulingController.php` fungsi `create()`, *developer* salah mendefinisikan direktori file *view* atau *Blade*. Ia mengarahkan kodenya ke `view('sopir.nota-hauling.create')`.
- Padahal, nama *folder* sesungguhnya di dalam `resources/views/sopir/` adalah `laporan-nota-hauling`, BUKAN `nota-hauling`.
- Sekali lagi, fungsi `edit()`, `update()`, dan `destroy()` juga hilang/terlupakan pada *controller* ini.

**Solusi / Perbaikan:**
- Mengoreksi penulisan path *view* dari `sopir.nota-hauling.create` menjadi `sopir.laporan-nota-hauling.create` agar file antarmuka (form penambahan nota) berhasil diakses.
- Menambahkan 3 fungsi yang hilang (`edit`, `update`, `destroy`) pada *controller* yang bersangkutan. Serta memastikan variabel yang dilempar (*compact*) ke tampilan edit disesuaikan dengan file Blade (`$laporan`, bukan `$nota`).

## 27. Undefined Variable `$sopirs` pada Edit Jadwal Operasional Manajer

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Undefined variable $sopirs` saat Manajer mencoba mengedit jadwal operasional (`/manajer/jadwal/{id}/edit`).

**Penyebab:**
- Pada `JadwalOperasionalController.php` (Manajer), fungsi `edit()` melemparkan variabel dengan nama `$sopir` dan `$mastertruk` ke *view* `edit.blade.php`.
- Namun, *file Blade* tersebut di-*coding* untuk mengharapkan variabel *collection* bernama `$sopirs` dan `$truks` (plural/jamak).
- Selain itu, nama input select untuk data truk di `edit.blade.php` ditulis sebagai `truk_id`, padahal *Controller* memvalidasinya sebagai `mastertruk_id`.

**Solusi / Perbaikan:**
- Mengubah seluruh penyebutan perulangan variabel di dalam `edit.blade.php` menjadi sinkron dengan nama variabel dari *Controller* (yaitu dari `$sopirs` menjadi `$sopir`, dan `$truks` menjadi `$mastertruk`).
- Memperbaiki atribut nama (*name*) dan *id* elemen `select` truk dari yang sebelumnya `truk_id` menjadi `mastertruk_id` supaya form lolos validasi saat di-submit untuk pembaruan data jadwal.

## 28. Error Validasi 'The tujuan field is required' pada Edit Jadwal Operasional Manajer

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`The tujuan field is required.` saat Manajer mencoba menekan tombol Perbarui pada form Edit Jadwal.

**Penyebab:**
- Pada fungsi `update` di `JadwalOperasionalController.php`, field input teks `tujuan` telah diatur sebagai data wajib (*required*).
- Akan tetapi, pada file `edit.blade.php`, form input teks untuk `tujuan` sama sekali tidak pernah dibuat/disertakan oleh *developer* lama (hanya ada *select* klien).
- Selain itu, pemanggilan properti untuk `Klien` juga salah (ditulis `$klien->nama`, padahal pada database nama kolomnya adalah `nama_perusahaan`).

**Solusi / Perbaikan:**
- Menambahkan satu buah grup form HTML lengkap (`<input type="text" name="tujuan" ...>`) pada file `edit.blade.php` sehingga pengguna bisa memasukkan field tujuan ini ke dalam sistem.
- Mengganti properti objek yang dipanggil pada dropdown Klien dari yang sebelumnya salah menjadi nama properti yang valid `{{ $klien->nama_perusahaan ?? '-' }}`.

## 29. Route 'manajer.laporan-kerusakan.show' Not Defined pada Laporan Kerusakan Manajer

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Route [manajer.laporan-kerusakan.show] not defined.` saat Manajer mengakses menu Laporan Kerusakan dan menekan tombol Detail (atau saat mencoba membuka halamannya).

**Penyebab:**
- Rute untuk fungsi `show` belum didefinisikan sama sekali di dalam `routes/web.php` pada *group* Manajer untuk menu laporan kerusakan.
- Beberapa fungsi *Controller* (`show`, `setujui`, `tolak`, `export`) di `ManajerKerusakanController.php` tidak ditulis padahal file *view* (`show.blade.php`) dan *route*-nya memanggil fungsi tersebut.
- Penamaan *route* di file *view* (`index.blade.php` dan `show.blade.php`) tidak sinkron dengan *route name* yang didaftarkan di `web.php` (misalnya view memanggil `manajer.laporan-kerusakan.approve`, namun di `web.php` namanya `kerusakan.setujui`).

**Solusi / Perbaikan:**
- Mendefinisikan ulang *route* yang kurang (termasuk `kerusakan.show` dan `maintenance.fromLaporan`) di `routes/web.php`.
- Melengkapi seluruh *method* fungsi yang hilang pada `ManajerKerusakanController.php` (yaitu `show`, `setujui`, `tolak`, dan `export`) beserta seluruh proses logika dasar (*import request* dan pengubahan status) di dalamnya.
- Menyeragamkan pemanggilan penamaan fungsi `route()` di dalam *view* `index.blade.php` dan `show.blade.php` sehingga cocok dan merujuk tepat pada nama rute baru yang kini sudah terdaftar dengan benar di `web.php`.

## 30. Route 'admin.maintenance.print' Not Defined pada Tombol Cetak Maintenance Manajer

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Route [admin.maintenance.print] not defined.` saat Manajer menekan tombol "Cetak Laporan" pada halaman Data Maintenance.

**Penyebab:**
- Pada `resources/views/Manajer/maintenance/index.blade.php`, aksi pada tombol cetak memanggil rute `admin.maintenance.print`.
- Pertama, _route name_ tersebut merupakan milik halaman admin. Kedua, nama aslinya di `web.php` (bagian admin) adalah `admin.maintenance.export`, sehingga nama rute `print` itu memang mutlak tidak ada.
- Untuk hak akses Manajer, rute pencetakan *maintenance* juga belum didefinisikan sama sekali di dalam *Controller* Manajer.

**Solusi / Perbaikan:**
- Membuat dan mendaftarkan *route* baru `Route::get('/maintenance-print', ...)` bernama `maintenance.print` pada kelompok Manajer di `routes/web.php`.
- Mengganti atribut href pada tombol cetak di `index.blade.php` milik Manajer menjadi `{{ route('manajer.maintenance.print') }}`.
- Menambahkan fungsi cetak PDF (`public function print()`) pada `ManajerMaintenanceController.php` dengan memanfaatkan package `dompdf`, mereload _view_ yang sama dengan admin (`admin.maintenance.export`), namun melakukan _streaming_ cetakannya langsung pada tab baru.

## 31. Call to undefined method AdminJadwalOperasionalController::export() pada Admin

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Call to undefined method App\Http\Controllers\Admin\AdminJadwalOperasionalController::export()` saat Admin mencoba mengekspor/mencetak Jadwal Operasional.

**Penyebab:**
- Di `routes/web.php`, tombol export PDF pada Jadwal Operasional diarahkan ke method `export` pada `AdminJadwalOperasionalController`.
- Namun, *method* di *controller* tersebut ternyata bernama `cetak` dan ia hanya me-*return* *view* HTML biasa tanpa package PDF.
- Pemanggilan variabel di tampilan *export* (`export.blade.php`) juga memanggil relasi yang salah/kosong (`$jadwal->sopir->nama` dan `$jadwal->plat_truk`).

**Solusi / Perbaikan:**
- Mengubah nama fungsi `cetak` menjadi `export` di dalam `AdminJadwalOperasionalController.php` agar sesuai dengan *route* yang terdaftar.
- Mengubah logika *return* dari sekadar merender *view* menjadi meng-*generate* PDF menggunakan `\PDF::loadView()` dan meresponsnya dengan `stream()` agar muncul di tab baru.
- Menambahkan pemanggilan relasi (*eager loading*) `->with(['sopir.user', 'truk'])` di query controller tersebut.
- Mengoreksi penamaan variabel di `export.blade.php` untuk menampilkan nama sopir (`$jadwal->sopir->user->nama ?? '-'`) dan plat nomor truk (`$jadwal->truk->plat_nomor ?? $jadwal->plat_nomor ?? '-'`).

## 32. Route 'admin.nota-hauling.update-status' Not Defined pada Laporan Nota Hauling Admin

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Route [admin.nota-hauling.update-status] not defined.` saat Admin membuka halaman Laporan Nota Hauling (yang mencoba me-render tombol Setujui/Tolak).

**Penyebab:**
- Di *view* `admin/nota-hauling/index.blade.php`, terdapat sekumpulan tombol aksi *(Approve/Reject)* yang diletakkan di dalam *form* dengan *action* memanggil `route('admin.nota-hauling.update-status')`.
- Sayangnya, rute `admin.nota-hauling.update-status` itu sama sekali belum didaftarkan di dalam *file routing* `routes/web.php` milik Admin.
- Lebih jauh lagi, fungsi untuk melakukan aksi *update status* ini juga belum pernah dibuat di dalam *Controller*-nya (`LaporanNotaHaulingController`).

**Solusi / Perbaikan:**
- Mendaftarkan *route* baru dengan HTTP verb `PATCH` ke url `notahauling/{id}/update-status` dengan nama `admin.nota-hauling.update-status` di `routes/web.php`.
- Melengkapi file `LaporanNotaHaulingController.php` dengan metode/fungsi tambahan bernama `updateStatus(Request $request, $id)` yang berisi logika untuk memvalidasi *request* dan memperbarui kolom `status` pada data `LaporanNotaHauling` menjadi "DISETUJUI" atau "DITOLAK".

## 33. Field 'muatan_netto' doesn't have a default value saat Sopir Menyimpan Trip Pulang

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`SQLSTATE[HY000]: General error: 1364 Field 'muatan_netto' doesn't have a default value` saat sopir mencoba menyimpan formulir dari halaman form trip pulang (`/sopir/trip-pulang/{id}/store`).

**Penyebab:**
- Pada `SopirTripPulangController.php` di dalam blok pembuatan entitas `Ritase` (ketika `tripBerangkat` tersedia), pembuatan datanya sangat tidak lengkap. *Controller* hanya menyisipkan `trip_berangkat_id` dan `sopir_id`.
- Pada *database schema* (tabel `ritase`), kolom seperti `muatan_netto`, `tarif`, `biaya_bbm`, `gaji_sopir`, dan `keuntungan_cv` tidak diizinkan untuk dikosongkan (bukan *nullable*) dan tidak mempunyai nilai awal bawaan (*default value*).
- *Fillable* property di dalam model `Ritase.php` juga tidak mengizinkan penambahan nama-nama kolom tersebut secara leluasa karena propertinya menggunakan penamaan yang tidak sama persis dengan tabel migrasinya (seperti `untung_cv` vs `keuntungan_cv`).

**Solusi / Perbaikan:**
- Memperbaiki array `$fillable` di dalam file model `Ritase.php` agar sama dan selaras dengan nama kolom migrasinya (`keuntungan_cv`, `biaya_bbm`, dll).
- Menambahkan suplai *array mapping* default yang lengkap ke dalam `Ritase::create([...])` di `SopirTripPulangController.php`. Kolom `muatan_netto` diisi dengan data `$request->muatan_netto`, `biaya_bbm` dari `$request->biaya_bbm`, serta memberi nilai dasar (sementara) `0` pada data keuangan seperti `tarif`, `gaji_sopir`, `keuntungan_cv`, dan `bonus` agar lolos dari validasi MySQL saat *insert* pertama kali.

## 34. Undefined variable $mastertruk pada Halaman Tambah Laporan Kerusakan Sopir

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`compact(): Undefined variable $mastertruk` saat Sopir mencoba mengakses halaman "Laporkan Kerusakan" (`/sopir/laporan-kerusakan/create`).

**Penyebab:**
- Pada fungsi `create()` di `App\Http\Controllers\Sopir\LaporanKerusakanController`, data truk yang diambil dari database disimpan ke dalam variabel bernama `$truks`. Namun anehnya, *controller* ini melempar datanya ke *view* menggunakan kode `compact('mastertruk')`. Karena nama variabelnya tidak *match* (beda nama), Laravel kebingungan dan melontarkan pesan *undefined variable*.
- Lebih jauh lagi, fungsi `store()` di *controller* yang sama mendefinisikan aturan validasi untuk inputan `tanggal_laporan` dan `deskripsi`, padahal pada *form HTML* di `create.blade.php`, atribut `name` yang di-set adalah `tanggal` dan `deskripsi_kerusakan`.

**Solusi / Perbaikan:**
- Mengubah kode `compact('mastertruk')` menjadi `compact('truks')` di dalam `LaporanKerusakanController.php` agar variabelnya terekstrak dengan benar ke dalam *view* HTML.
- Menyelaraskan aturan validasi (*validation rules*) dan pendefinisian array di method `store()`, dengan mengganti `tanggal_laporan` menjadi `tanggal`, serta mengganti nama variabel `deskripsi` menjadi `deskripsi_kerusakan`, sesuai dengan atribut *name* pada formulir.

## 35. Call to undefined method JadwalSopirController::selesaiPerjalanan() pada Sopir

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`Call to undefined method App\Http\Controllers\Sopir\JadwalSopirController::selesaiPerjalanan()` saat Sopir mencoba menekan tombol selesaikan perjalanan dari jadwal berangkat.

**Penyebab:**
- Di file `routes/web.php`, tombol untuk mulai, selesai, dan batal perjalanan dipetakan ke *controller* `JadwalSopirController` dengan memanggil method `mulaiPerjalanan`, `selesaiPerjalanan`, dan `batalkanPerjalanan`.
- Sayangnya, penamaan fungsi-fungsi yang benar-benar ada di dalam file `JadwalSopirController.php` adalah `mulai()`, `selesai()`, dan `batal()`.
- Ketidakselarasan nama method ini menyebabkan Laravel kebingungan dan membuang error *undefined method*.

**Solusi / Perbaikan:**
- Mengedit pemetaan *route* untuk Sopir (Kontrol Jadwal) di dalam `routes/web.php` agar mencerminkan nama fungsi sebenarnya pada *Controller*. 
- Perubahan dilakukan dari `mulaiPerjalanan` menjadi `mulai`, `selesaiPerjalanan` menjadi `selesai`, dan `batalkanPerjalanan` menjadi `batal`.

## 36. Warning: 1265 Data truncated for column 'status' pada Laporan Nota Hauling

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`SQLSTATE[01000]: Warning: 1265 Data truncated for column 'status' at row 1 (Connection: mysql, SQL: update laporan_nota_hauling set status = DISETUJUI...` saat Admin menyetujui (Approve) Nota Hauling.

**Penyebab:**
- Pada kode *view* dan *controller* sebelumnya, aksi persetujuan mengirimkan string `DISETUJUI` atau `DITOLAK` ke dalam database untuk memperbarui kolom `status`.
- Sayangnya, kolom `status` pada tabel `laporan_nota_hauling` didesain menggunakan tipe data ENUM yang hanya menerima kumpulan nilai bahasa inggris: `['MENUNGGU', 'APPROVED', 'REJECTED']`. 
- Karena MySQL tidak mengenali kata `DISETUJUI`, maka MySQL memotong (truncate) data tersebut dan menolak menyimpannya.

**Solusi / Perbaikan:**
- Mengubah pengiriman *value* pada tombol *action* di halaman Laporan Nota Hauling (`resources/views/admin/nota-hauling/index.blade.php`). Kata `DISETUJUI` diganti dengan `APPROVED` dan kata `DITOLAK` diganti dengan `REJECTED`.
- Menyesuaikan juga penangkapan kondisi *if else* warna *badge* di file view yang sama, agar membaca status `APPROVED` dan `REJECTED`.
- Menyinkronkan aturan validasi `in:` yang berada pada metode `updateStatus` di file `LaporanNotaHaulingController.php` dari `DISETUJUI,DITOLAK` menjadi `APPROVED,REJECTED`.

## 37. Jadwal Operasional Baru Tidak Muncul (Gagal Tersimpan secara Diam-diam)

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
Tidak ada pesan *error* di layar pengguna (Manajer). Namun secara internal pada *database* terjadi `SQLSTATE[22007]: Invalid datetime format: 1366 Incorrect integer value: '' for column 'klien_id'` yang menggagalkan penyimpanan jadwal.

**Penyebab:**
- Pada saat Manajer menambah jadwal baru dan membiarkan *input* "Klien" tetap kosong (`Pilih Klien`), nilai yang dilempar ke *Controller* adalah string kosong (`""`). 
- Sistem mencoba menyimpan `""` ke dalam kolom `klien_id` yang bertipe angka (Integer) di dalam *database*.
- Mode *Strict* MySQL menolak hal tersebut, menyebabkan gagal simpan (Error 500 internal). 
- Parahnya, halaman `create.blade.php` untuk jadwal tidak dilengkapi kode penampil validasi error (`@error`), sehingga pengguna tidak menyadari bahwa formnya gagal diproses dan meyakini bahwa jadwal telah dibuat.

**Solusi / Perbaikan:**
- Di `JadwalOperasionalController.php` (Manajer), pada *method* `store` dan `update`, disisipkan konversi logika di mana jika input opsional (`klien_id`, `rute`, `bruto`, `tara`, `no_surat_jalan`, `catatan`) dikirim kosong (`""`), maka nilainya akan secara tegas diubah menjadi tipe `null` yang sah di database (contoh: `$request->klien_id ?: null`).
- Di `resources/views/manajer/jadwal/create.blade.php`, ditambahkan fungsi peringatan validasi form Laravel (`@error` dan `is-invalid`) di bawah setiap input. Sehingga kini jika Manajer lupa memasukkan kolom wajib, pesan peringatan warna merah akan muncul memberitahu form yang salah.

## 38. Error 'Column not found: uang_makan' saat Sopir Memulai Trip (Internal Server Error 500)

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
`SQLSTATE[42S22]: Column not found: 1054 Unknown column 'uang_makan' in 'field list'` ketika Sopir men-submit form 'Mulai Trip' di `sopir/trip-berangkat/{id}/store`.

**Penyebab:**
- `SopirTripBerangkatController` (dan `SopirTripPulangController`) mencoba menyimpan berbagai data uang seperti `uang_makan`, `muatan_netto`, `biaya_bbm`, dan `ritase` secara langsung ke dalam model `JadwalOperasional` (`$jadwal->update(...)`). 
- Faktanya, kolom-kolom finansial dan operasional spesifik tersebut sengaja dipisahkan dari tabel induk dan berada di dalam tabel `trip_berangkat` serta `trip_pulang`.
- Memaksa penyimpanan kolom yang tidak ada pada `jadwal_operasional` menyebabkan sistem *crash* (Error 500).
- Tambahan: Di file *view* `trip-pulang/form.blade.php`, *input* HTML untuk Harga BBM bernama `harga_bbm`, tetapi Controller memvalidasi dan memprosesnya dengan nama `biaya_bbm`.

**Solusi / Perbaikan:**
- Melakukan penyesuaian besar pada *Controller* Trip Berangkat (`SopirTripBerangkatController@store`): Proses penyimpanan kini memisahkan atribut yang dimiliki tabel utama `jadwal_operasional` dengan atribut pendukung (seperti `uang_makan`, `uang_jalan`) yang kemudian dimasukkan secara benar ke dalam tabel relasinya menggunakan sintaks `\App\Models\TripBerangkat::updateOrCreate(...)`.
- Melakukan penyesuaian yang sama pada *Controller* Trip Pulang (`SopirTripPulangController@store`): Mengamankan kolom `netto` dan `rit_ke`, serta merekam `muatan_netto`, `ritase`, `biaya_bbm` dengan benar ke dalam `\App\Models\TripPulang::updateOrCreate(...)`.
- Menyelaraskan array `$fillable` di dalam file `TripBerangkat.php` dan `TripPulang.php` agar dapat menerima semua variabel di atas dari *Controller*.
- Mengganti atribut name `harga_bbm` menjadi `biaya_bbm` di `resources/views/sopir/trip-pulang/form.blade.php` agar sinkron dengan aturan Controller.

## 39. Trip yang Telah 'Mulai Perjalanan' Menghilang dari Halaman Sopir

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
Tidak ada *error* sistem, namun jadwal yang sudah disubmit di "Trip Berangkat" menghilang begitu saja dan tidak bisa ditemukan di "Trip Pulang" untuk diselesaikan.

**Penyebab:**
- Saat Sopir mengklik tombol "Mulai Trip" dan sukses diproses, status jadwal berubah menjadi `Berangkat`.
- Namun anehnya, halaman `Trip Pulang` (yang dirancang untuk menyelesaikan trip) hanya men-filter pencarian untuk status `['Pulang', 'Selesai']`.
- Karena statusnya `Berangkat` (bukan `Pulang` maupun `Selesai`), trip tersebut tersaring keluar dan tidak muncul di daftar Trip Pulang. Dan karena sudah bukan `Siap Berangkat`, ia juga tidak muncul di halaman Trip Berangkat. Status ini menjadi status "hantu" (stuck) di dalam sistem.

**Solusi / Perbaikan:**
- Mengedit query pada `SopirTripPulangController@index` agar turut memanggil jadwal dengan status `Berangkat` (`whereIn('status', ['Berangkat', 'Pulang', 'Selesai'])`).
- Membuka validasi *middleware-like* pada metode `form` dan `store` di controller tersebut agar membolehkan jadwal berstatus `Berangkat` diproses ke form Pulang.
- Di tampilan antarmuka (UI) file `resources/views/sopir/trip-pulang/index.blade.php`, fungsi *if-else* diubah agar menampilkan tombol **"Isi Form Pulang"** untuk trip yang masih berstatus `Berangkat`.

## 40. Tambah Jadwal dari Manajer Gagal Tersimpan (Error 500 TypeError string subtraction)

**Tanggal/Waktu:** 3 Juli 2026

**Pesan Error:**
Sistem gagal menyimpan form ke *database* dan me-lempar *Error 500 Internal Server Error* secara diam-diam (sehingga terlihat seakan-akan tidak tersimpan/muncul di sopir).
Di balik layar: `TypeError: Unsupported operand types: string - string` di baris `$netto = ($request->bruto ?? 0) - ($request->tara ?? 0);`

**Penyebab:**
- Karena sistem berjalan menggunakan PHP 8, pengurangan dua buah karakter teks kosong (`"" - ""`) dianggap sebagai *error* fatal (`TypeError`). Di PHP 7, ini biasanya tidak masalah karena akan di-casting otomatis menjadi `0 - 0 = 0`.
- Ketika Manajer mengisi form tambah jadwal baru tanpa mengisi kolom opsional `bruto` dan `tara` (dibiarkan kosong alias `""`), kode di `JadwalOperasionalController@store` mencoba mengurangkannya.
- Karena kode bawaannya ditulis `$netto = ($request->bruto ?? 0) - ($request->tara ?? 0);`, nilai `""` bukanlah `null` sehingga `??` (Null Coalescing) gagal merubahnya menjadi `0`, dan tetap melakukan `"" - ""`, yang memicu *error* PHP 8.

**Solusi / Perbaikan:**
- Memperbaiki logika penghitungan netto pada metode `store` dan `update` di `JadwalOperasionalController.php` (Manajer).
- Melakukan *casting* ke `(float)` dan mengecek string kosong (`!== ''`) sebelum melakukan perhitungan matematika.
- Kode menjadi:
  ```php
  $bruto = $request->bruto !== null && $request->bruto !== '' ? (float) $request->bruto : 0;
  $tara = $request->tara !== null && $request->tara !== '' ? (float) $request->tara : 0;
  $netto = $bruto - $tara;
  ```
