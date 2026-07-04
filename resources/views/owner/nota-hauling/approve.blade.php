<form action="{{ route('owner.nota-hauling.approve', $nota->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-success btn-sm">Approve</button>
</form>

<form action="{{ route('owner.nota-hauling.reject', $nota->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
</form>
