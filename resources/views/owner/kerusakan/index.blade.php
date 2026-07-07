@extends('layout.main')
@include('partials.sidebar-owner')
@section('title', 'Laporan Kerusakan')

@section('content')
<div class="container mt-4">
  <h4>Laporan Kerusakan Truk</h4>
  <table class="table table-bordered table-sm mt-3">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Sopir</th>
        <th>Truk</th>
        <th>Deskripsi Kerusakan</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($kerusakan as $k)
        <tr>
          <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</td>
          <td>{{ $k->sopir->nama ?? '-' }}</td>
          <td>{{ $k->mastertruk->plat_nomor ?? '-' }}</td>
          <td>{{ $k->deskripsi_kerusakan }}</td>
          <td>
            <span class="badge 
              {{ in_array(strtoupper($k->status), ['DISETUJUI', 'DISETUJUI MANAJER']) ? 'badge-success' : 'badge-danger' }}">
              {{ $k->status }}
            </span>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5" class="text-center">Tidak ada laporan kerusakan yang ditemukan.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
