@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Laporan Saya')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1 class="m-0">Laporan Saya</h1>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <a href="{{ route('sopir.laporan.create') }}" class="btn btn-primary mb-3">Tambah Laporan</a>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Laporan</h3>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover">
          <thead>
            <tr>
              <th style="width: 200px;">Tanggal</th>
              <th>Isi Laporan</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($laporans as $laporan)
              <tr>
                <td>{{ $laporan->tanggal }}</td>
                <td>{{ $laporan->isi_laporan }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
