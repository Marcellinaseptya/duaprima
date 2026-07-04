@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Upload Nota')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Unggah Nota Pengeluaran</h4>

    {{-- Alert sukses --}}
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Alert validasi --}}
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Form Upload --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <p>
                Unggah nota pengeluaran perjalananmu ya. Bisa termasuk:
                <ul>
                    <li>🛣️ <strong>Nota Perjalanan</strong> (misal: hauling batubara)</li>
                    <li>⛽ <strong>Nota BBM</strong></li>
                    <li>🔧 <strong>Nota Perbaikan</strong></li>
                </ul>
                File harus format <strong>JPG, PNG, atau PDF</strong>. Max 2MB.
            </p>

            <form method="POST" action="{{ route('sopir.nota-pengeluaran.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="jenis">Jenis Nota <small class="text-danger">*</small></label>
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="hauling">Perjalanan</option>
                        <option value="bbm">BBM</option>
                        <option value="perbaikan">Perbaikan</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="file_nota">File Nota <small class="text-danger">*</small></label>
                    <input type="file" name="file_nota" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>

                <div class="form-group mt-3">
                    <label for="keterangan">Keterangan (opsional)</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Isi BBM di SPBU A">
                </div>

                <div class="form-group mt-3">
                    <label for="tanggal">Tanggal <small class="text-danger">*</small></label>
                    <input type="date" name="tanggal" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Unggah Nota</button>
            </form>
        </div>
    </div>

    {{-- Riwayat Nota --}}
    <h5 class="mt-5">Riwayat Nota</h5>
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>File</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notas as $nota)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($nota->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($nota->jenis) }}</td>
                    <td><a href="{{ Storage::url($nota->file_nota) }}" target="_blank">Lihat File</a></td>
                    <td>{{ $nota->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada nota yang diunggah.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
