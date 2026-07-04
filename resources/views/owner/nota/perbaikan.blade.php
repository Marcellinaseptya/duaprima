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
        <th>Truk</th>
        <th>Sopir</th>
        <th>Jenis</th>
        <th>Biaya</th>
        <th>Bukti</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($notaPerbaikan as $n)
        <tr>
          <td>{{ \Carbon\Carbon::parse($n->tanggal)->format('d M Y') }}</td>
          <td>{{ $n->truk->plat_nomor ?? '-' }}</td>
          <td>{{ $n->sopir->nama ?? '-' }}</td>
          <td>{{ $n->jenis_perbaikan }}</td>
          <td>Rp{{ number_format($n->biaya) }}</td>
          <td>
            @if($n->bukti_nota)
              <a href="{{ asset('storage/' . $n->bukti_nota) }}" target="_blank">Lihat</a>
            @else
              <span class="text-muted">-</span>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
