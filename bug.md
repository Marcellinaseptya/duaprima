# Daftar Bug Hasil Analisis Awal

Berdasarkan pengecekan file, rute, dan log pada sistem, berikut adalah daftar bug yang ditemukan sebelum melakukan perbaikan:

## 1. File Kosong (0 Bytes) - Bagian Core & Controller
Beberapa file core dan controller ternyata kosong (0 bytes). Hal ini menyebabkan *fatal error* seperti `ReflectionException` di Laravel ketika mencoba memuat class tersebut (misalnya saat menjalankan `php artisan route:list` atau mengakses fitur terkait).

File yang terdampak:
- `app/Http/Controllers/Admin/GajiSopirController.php`
- `app/Http/Controllers/Sopir/NotaController.php`
- `app/Http/Middleware/RedirectIfAuthenticated.php` *(Middleware bawaan untuk redirect jika user sudah login)*
- `app/Models/Nota.php`
- `app/Http/Controllers/Sopir/n` *(Sepertinya file yang terbuat secara tidak sengaja/typo)*

## 2. File Kosong (0 Bytes) - Bagian Views (Blade)
Selain class PHP, ditemukan juga beberapa file tampilan (views) yang kosong (0 bytes) atau salah penamaan, yang akan menyebabkan layar putih blank atau error saat diakses:
- `resources/views/transaksi_keuangan.blade.php`
- `resources/views/admin/jadwal-operasional/create.blade.php`
- `resources/views/admin/maintenance/export.blade.php`
- `resources/views/admin/tripberangkat/create` *(Bahkan file ini tidak memiliki ekstensi `.blade.php`)*

## 3. Konflik Namespace pada Controller
Ditemukan *Fatal Error* terkait bentrok nama class (namespace): 
- `app/Http/Controllers/Sopir/RitaseController.php` menggunakan namespace `namespace App\Http\Controllers\Admin;` yang salah, seharusnya `namespace App\Http\Controllers\Sopir;`. Ini menyebabkan error *Cannot declare class App\Http\Controllers\Admin\RitaseController, because the name is already in use*.

## 4. Rute Base (`/`) Tidak Ditemukan
Pada file `routes/web.php`, tidak terdapat rute untuk URL dasar (root route `/`). Saat ini, aplikasi akan mengembalikan error 404 jika diakses tanpa URL spesifik. Hal ini juga dibuktikan dari kegagalan file `tests/Feature/ExampleTest.php` yang mencoba mengakses `GET /`.

## 5. Sisa Error Seeder (Sudah Ditandai di `perbaikan.md`, namun perlu dipastikan)
Sebelumnya terdapat isu-isu seputar database seeder:
- Error duplicate entry untuk `admin@gmail.com`.
- Error pemanggilan `KategoriSeeder::class` yang mencari tabel `kategoris` (tabel yang tidak ada di sistem ini).
Berdasarkan pengecekan, kode ini sepertinya telah diubah di source code (seperti penggunaan `updateOrCreate`), namun command `php artisan db:seed` belum dijalankan dengan bersih.

## 6. Gagal Login (Akun Tidak Ditemukan)
Berdasarkan pengujian langsung di *browser* pada alamat `http://localhost:8000/login`:
- Halaman login dapat dimuat dengan baik.
- Namun, ketika mencoba masuk menggunakan akun default (misal: `admin@gmail.com` dengan password `admin123`), sistem menampilkan error **"Email atau password salah."**
- **Penyebab Utama**: Hal ini karena data *user* dan *role* belum berhasil masuk ke database akibat error pada seeder (bug nomor 5). Akibatnya, belum ada akun satupun yang bisa dipakai untuk mengakses sistem.

---
*Catatan: Kami akan memperbaiki bug-bug ini satu per satu dengan mengembalikan isi file (meng-generate ulang kode yang tepat) dan memastikan seluruh rute serta dependensi berjalan dengan semestinya.*
