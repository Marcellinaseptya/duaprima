@extends('layout.main')
@section('content')
<div class="container-fluid py-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Buat Jadwal Operasional</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.jadwal-operasional.store') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
