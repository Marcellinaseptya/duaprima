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
        <th>Jenis Kerusakan</th>
        <th>Keterangan</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($kerusakan as $k)
        <tr>
          <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</td>
          <td>{{ $k->sopir->nama ?? '-' }}</td>
          <td>{{ $k->truk->plat_nomor ?? '-' }}</td>
          <td>{{ $k->jenis }}</td>
          <td>{{ $k->keterangan }}</td>
          <td>
            <span class="badge 
              {{ $k->status == 'Disetujui Manajer' ? 'badge-success' : 'badge-danger' }}">
              {{ $k->status }}
            </span>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
