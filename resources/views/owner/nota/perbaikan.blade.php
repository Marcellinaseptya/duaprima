@extends('layout.main')
@include('partials.sidebar-owner')
@section('title', 'Nota Perbaikan')

@section('content')
<div class="container mt-4">
  <h4>Nota Perbaikan</h4>
  <table class="table table-bordered table-sm mt-3">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Sopir</th>
        <th>Keterangan</th>
        <th>File Bukti</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($notaPerbaikan as $n)
        <tr>
          <td>{{ \Carbon\Carbon::parse($n->tanggal)->format('d M Y') }}</td>
          <td>{{ $n->sopir->user->nama ?? '-' }}</td>
          <td>{{ $n->keterangan ?? '-' }}</td>
          <td>
            @if($n->file_nota)
              <a href="{{ asset('storage/' . $n->file_nota) }}" target="_blank">Lihat</a>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center text-muted">Belum ada nota perbaikan yang diunggah.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
