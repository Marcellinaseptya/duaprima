@extends('layout.main')
@include('partials.sidebar-owner')
@section('title', 'Laporan Keuangan')

@section('content')
<div class="container mt-4">
  <h4>Laporan Keuangan Bulan {{ $bulan }} / {{ $tahun }}</h4>
  <ul class="list-group mt-3">
    <li class="list-group-item d-flex justify-content-between">
      <span>Total Pemasukan</span>
      <strong>Rp{{ number_format($totalPemasukan) }}</strong>
    </li>
    <li class="list-group-item d-flex justify-content-between">
      <span>Total BBM</span>
      <span>Rp{{ number_format($totalBbm) }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
      <span>Total Perbaikan</span>
      <span>Rp{{ number_format($totalPerbaikan) }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
      <span>Total Pinjaman Sopir</span>
      <span>Rp{{ number_format($totalPinjaman) }}</span>
    </li>
    <li class="list-group-item d-flex justify-content-between">
      <strong>Total Pengeluaran</strong>
      <strong>Rp{{ number_format($totalPengeluaran) }}</strong>
    </li>
    <li class="list-group-item d-flex justify-content-between">
      <strong>Laba Bersih</strong>
      <strong>Rp{{ number_format($labaBersih) }}</strong>
    </li>
  </ul>
</div>
@endsection
