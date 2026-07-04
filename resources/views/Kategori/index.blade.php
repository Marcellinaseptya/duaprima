@extends('layout.main')

@section('content')
<div class="container">
    <h1>Daftar Kategori</h1>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $item)
            <tr>
                <td>{{ $item->id }}</td> <!-- Tambahkan kolom ID -->
                <td>{{ $item->nama_kategori }}</td>
                <td>
                    <!-- Tombol Edit -->
                    <a href="{{ route('kategori.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                    <!-- Tombol Hapus -->
                    <button class="btn btn-sm btn-danger" 
                            data-id="{{ $item->id }}" 
                            data-name="{{ $item->nama_kategori }}" 
                            data-toggle="modal" 
                            data-target="#confirmDeleteModal">
                        Hapus
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Anda yakin ingin menghapus kategori <strong id="modal-category-name"></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Script Modal Konfirmasi -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const confirmDeleteModal = document.getElementById('confirmDeleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const modalName = document.getElementById('modal-category-name');

        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget); // Tombol yang memicu modal
            const id = button.data('id');
            const name = button.data('name');

            // Set nama dan action form
            modalName.textContent = name;
            deleteForm.action = '/kategori/' + id;
        });
    });
</script>
@endsection
