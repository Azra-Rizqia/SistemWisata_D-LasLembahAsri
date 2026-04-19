<button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#delete-{{ $item->id }}">
    <i class="ph ph-trash icon icon-sm icon-danger"></i>
</button>
<x-modal-delete id="delete-{{ $item->id }}" action="{{ route('sewa_kios.destroy', $item->id) }}"
    title="Apakah Anda Yakin Untuk Menghapus?"
    message="Jika anda menghapus pesanan ini, maka anda tidak dapat memulihkannya lagi" />
