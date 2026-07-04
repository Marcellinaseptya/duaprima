@extends('layout.main')
@include('partials.sidebar-owner')
@section('title', 'Nota BBM')

@section('content')
<div class="container mt-4">
  <h4>Nota BBM</h4>
  <table class="table table-bordered table-sm mt-3">
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Sopir</th>
        <th>Truk</th>
        <th>Jumlah</th>
        <th>File</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($notaBbm as $n)
        <tr>
          <td>{{ \Carbon\Carbon::parse($n->tanggal)->format('d M Y') }}</td>
          <td>{{ $n->sopir->nama ?? '-' }}</td>
          <td>{{ $n->truk->plat_nomor ?? '-' }}</td>
          <td>Rp{{ number_format($n->jumlah) }}</td>
          <td>
            @if($n->file)
              <a href="{{ asset('storage/' . $n->file) }}" target="_blank">Lihat</a>
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
