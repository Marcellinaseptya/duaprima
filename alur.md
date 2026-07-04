# Alur Sistem (Bussines Flow) - Sistem Manajemen Armada Truk

Dokumen ini menjelaskan alur kerja (flow) dari aplikasi berdasarkan struktur database, pembagian hak akses (role), dan rute yang tersedia.

## 1. Hak Akses (Role) Pengguna
Sistem ini membagi akses menjadi 4 peran utama:
- **Admin**: Bertindak sebagai operator utama yang mengatur data master, menugaskan jadwal, dan mengurus administrasi/keuangan.
- **Manajer**: Mengawasi operasional harian dan menyetujui (approve) berbagai laporan seperti laporan kerusakan.
- **Sopir**: Sebagai pengguna di lapangan yang menjalankan jadwal, melaporkan ritase, dan mengajukan laporan kerusakan.
- **Owner**: Bertindak sebagai pimpinan yang memantau rekap keseluruhan operasional dan menyetujui nota tingkat lanjut.

---

## 2. Alur Manajemen Data Master (Persiapan Awal)
Sebelum operasional dapat berjalan, **Admin** harus menyiapkan data-data fundamental:
1. **Data Klien**: Mendata perusahaan/pihak yang menyewa jasa angkut (hauling).
2. **Data Truk (Master Truk)**: Mendata armada truk yang dimiliki, plat nomor, jenis, dan merk truk.
3. **Data Sopir & User**: Mendaftarkan karyawan sopir serta membuatkan akun login (User) agar mereka bisa mengakses sistem.
4. **Data Sparepart**: Mencatat daftar suku cadang yang tersedia beserta stoknya (bisa bertambah lewat `Pembelian Sparepart`).

---

## 3. Alur Operasional Lapangan (Trip & Hauling)
Ini adalah siklus utama dalam pengiriman barang.
1. **Pembuatan Jadwal**: **Admin/Manajer** membuat `Jadwal Operasional` yang memasangkan Klien dengan Sopir dan Truk yang akan beroperasi pada tanggal/waktu tertentu.
2. **Mulai Perjalanan (Trip Berangkat)**: 
   - **Sopir** login, melihat jadwalnya, lalu menekan tombol mulai/buat *Trip Berangkat*.
   - Sopir berangkat menuju lokasi muat atau klien.
3. **Selesai Perjalanan (Trip Pulang)**: 
   - Setelah muatan diturunkan, **Sopir** membuat *Trip Pulang* menuju pool/lokasi awal.
4. **Perhitungan Ritase**: Setiap satu siklus keberangkatan dan kepulangan yang selesai akan dihitung sebagai **Ritase**. Laporan ini dapat dilihat oleh Admin dan Owner untuk menentukan performa sopir.

---

## 4. Alur Perawatan dan Perbaikan (Maintenance)
Jika terjadi kendala pada kendaraan, proses ini akan berjalan:
1. **Laporan Kerusakan**: Saat truk bermasalah, **Sopir** mengajukan `Laporan Kerusakan` melalui aplikasinya.
2. **Persetujuan Manajer**: Laporan tersebut masuk ke halaman **Manajer**. Manajer akan memeriksa dan menentukan apakah kerusakan disetujui untuk diperbaiki atau ditolak.
3. **Proses Maintenance**: Jika disetujui, **Admin** akan memproses perbaikan ke dalam tabel `Maintenance`. Proses ini dapat mencatat biaya perbaikan serta memotong stok `Sparepart` yang digunakan. Jika stok menipis, Admin bisa mencatat `Pembelian Sparepart`.

---

## 5. Alur Keuangan dan Administrasi
Seluruh aktivitas di lapangan bermuara pada pendataan keuangan:
1. **Laporan Nota**: Selama di jalan, **Sopir** mengunggah bukti pengeluaran melalui fitur `Nota Pengeluaran` (misal: BBM, tambal ban) dan menyerahkan `Nota Hauling` (surat jalan).
2. **Penggajian**: Berdasarkan jumlah *Ritase* yang diselesaikan oleh Sopir, **Admin** menghitung dan menerbitkan `Gaji Sopir`.
3. **Penagihan (Invoice)**: Berdasarkan pengiriman/hauling yang selesai, **Admin** menerbitkan `Invoice` (tagihan) untuk menagih pembayaran kepada **Klien**.
4. **Rekap Keuangan**: Semua aliran uang (Uang masuk dari Invoice, uang keluar untuk Gaji, Nota Pengeluaran, dan Maintenance) akan bermuara di **Laporan Keuangan** yang utuh.

---

## 6. Alur Pemantauan Eksekutif (Owner Dashboard)
- **Owner** dapat membuka sistem untuk memantau langsung performa keuangan bulanan, jumlah ritase harian, serta pengeluaran yang terjadi akibat kerusakan mesin. 
- Pada kondisi tertentu, Owner juga berwenang melakukan validasi/approval atas dokumen *Nota Hauling* atau *Keuangan* dalam skala besar.

---

## 7. Alur Relasi Database (Entity Relationships)
Sistem ini sangat terintegrasi. Berikut adalah alur relasi antar-tabel utamanya:
- **`users` ↔ `sopir`**: Satu *user* (dengan *role* sopir) terhubung ke satu profil *Sopir*. Semua data sopir merujuk ke tabel *Users*.
- **`jadwal_operasional`**: Merupakan titik temu (persimpangan) dari 3 master data. Tabel ini mengambil `sopir_id`, `truk_id` (dari *Master Truk*), dan `klien_id` untuk membuat satu penugasan.
- **`trip_berangkat` & `trip_pulang`**: Mengacu pada `sopir_id`, `master_truk_id`, dan `klien_id`. Tabel *Trip Pulang* secara spesifik terikat ke *Trip Berangkat* (`trip_berangkat_id`) karena kepulangan tidak akan ada tanpa keberangkatan.
- **`ritase`**: Terikat ke `sopir_id` sebagai hasil akhir dari siklus trip berangkat-pulang.
- **`laporan_kerusakan`**: Diajukan oleh `sopir_id` dan menunjuk ke `truk_id` (atau `mastertruk_id`) yang bermasalah.
- **`maintenance` (Perbaikan)**: Bergantung pada `laporan_kerusakan_id` (sebagai dasar perbaikan) dan mengikat ke `mastertruk_id`.
- **`pembelian_sparepart`**: Terikat secara langsung ke tabel master `sparepart` (`sparepart_id`) untuk menambah stok.
- **`nota_pengeluaran`, `nota_hauling`, `nota_bbm`, `nota_perbaikans`**: Semua jenis nota ini terikat kuat ke `sopir_id` (sebagai pelapor/pengklaim), dan sebagian terikat ke `jadwal_id` (`laporan_nota`).
- **`invoice`**: Terikat ke `klien_id` untuk menagih biaya *hauling*.
- **`gaji_sopir` & `pinjaman_sopir`**: Terikat langsung ke entitas `sopir_id` untuk kalkulasi *payroll*.
- **`transaksi`**: Terikat ke `user_id` (siapa yang mencatat) dan bisa merujuk ke `sopir_id` (jika berkaitan dengan kas bon / pinjaman sopir).
