@extends('layout.main')
@include('partials.sidebar-sopir')

@section('title', 'Mulai Trip')

@section('content')
<div class="container mt-4">
    <h3>Mulai Perjalanan</h3>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('sopir.trip-berangkat.store', $jadwal->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Lokasi Berangkat --}}
        <div class="mb-3">
            <label for="lokasi_berangkat" class="form-label">Lokasi Berangkat</label>
            <input type="text" class="form-control @error('lokasi_berangkat') is-invalid @enderror" 
                   name="lokasi_berangkat" value="{{ old('lokasi_berangkat', $jadwal->lokasi_berangkat ?? '') }}">
            @error('lokasi_berangkat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Uang Jalan --}}
        <div class="mb-3">
            <label for="uang_jalan" class="form-label">Uang Jalan</label>
            <input type="text" class="form-control uang @error('uang_jalan') is-invalid @enderror" 
                   name="uang_jalan" value="{{ old('uang_jalan') }}">
            @error('uang_jalan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Uang Makan --}}
        <div class="mb-3">
            <label for="uang_makan" class="form-label">Uang Makan</label>
            <input type="text" class="form-control uang @error('uang_makan') is-invalid @enderror" 
                   name="uang_makan" value="{{ old('uang_makan') }}">
            @error('uang_makan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Catatan --}}
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan">{{ old('catatan') }}</textarea>
            @error('catatan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Nota Perjalanan --}}
        <div class="mb-3">
            <label for="nota_perjalanan" class="form-label">Upload Nota Perjalanan</label>
            <input type="file" class="form-control @error('nota_perjalanan') is-invalid @enderror" 
                   name="nota_perjalanan" id="nota_perjalanan">
            @error('nota_perjalanan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- Preview file --}}
            <div class="mt-2">
                <img id="previewNota" src="#" alt="Preview Nota" style="display:none; max-height:150px;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Mulai Trip</button>
        <a href="{{ route('sopir.trip-berangkat.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Format input uang
    document.querySelectorAll('.uang').forEach(function(input){
        input.addEventListener('input', function(){
            let value = this.value.replace(/[^0-9]/g,'');
            this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });

    // Preview file image
    const notaInput = document.getElementById('nota_perjalanan');
    const preview = document.getElementById('previewNota');
    notaInput.addEventListener('change', function(){
        const file = this.files[0];
        if(file && file.type.startsWith('image/')) {
            preview.style.display = 'block';
            preview.src = URL.createObjectURL(file);
        } else {
            preview.style.display = 'none';
            preview.src = '#';
        }
    });
</script>
@endsection
