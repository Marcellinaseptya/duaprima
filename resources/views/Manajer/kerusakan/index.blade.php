@extends('layout.main')
@include('partials.sidebar-manajer')
@section('title', 'Laporan Kerusakan')

@section('content')
<div class="container mt-4">
  <h2>Laporan Kerusakan</h2>
  <a href="{{ route('manajer.kerusakan.export') }}" class="btn btn-sm btn-success mb-2">Export PDF</a>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Sopir</th>
        <th>Tanggal</th>
        <th>Deskripsi</th>
        <th>Status</th>
        <th>Bukti</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($laporans as $i => $laporan)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $laporan->sopir->nama ?? '-' }}</td>
        <td>{{ $laporan->tanggal }}</td>
        <td>{{ $laporan->deskripsi }}</td>
        <td>{{ ucfirst($laporan->status) }}</td>
        <td>
          @if($laporan->file_bukti)
            <a href="{{ asset('storage/' . $laporan->file_bukti) }}" target="_blank">Lihat</a>
          @else
            -
          @endif
        </td>
        <td>
          <form method="POST" action="{{ route('manajer.kerusakan.updateStatus', $laporan->id) }}">
            @csrf
            <select name="status" onchange="this.form.submit()" class="form-control form-control-sm">
              <option value="">-- Pilih Status --</option>
              <option value="disetujui" {{ $laporan->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
              <option value="ditolak" {{ $laporan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
