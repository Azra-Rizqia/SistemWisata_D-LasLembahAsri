<div class="modal fade"
     id="{{ $id }}"
     data-bs-backdrop="static"
     data-bs-keyboard="false"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px; padding: 20px;">

            <div class="modal-header d-flex justify-content-center border-0">
                <div class="icon-card-delete items-center">
                    <i class="ph ph-trash icon icon-md icon-danger"></i>
                </div>
            </div>

            <div class="modal-body d-flex flex-column text-center gap-3">
                <h1 class="font-T1-SemiBold">{{ $title }}</h1>
                <p class="font-T3-Regular">{{ $message }}</p>
            </div>

            <div class="modal-footer font-T4-Regular d-flex gap-2 border-0">
                <button type="button"
                        class="btn btn-secondary flex-fill"
                        data-bs-dismiss="modal">
                    Kembali
                </button>

                {{ $slot }}
            </div>

        </div>
    </div>
</div>
