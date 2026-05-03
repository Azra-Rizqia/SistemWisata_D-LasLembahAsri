@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-5 rounded-4 shadow-sm text-center" style="max-width: 500px; width: 100%;">

        <h3 class="font-h1 mb-2">Selesaikan Pembayaran</h3>
        <p class="font-T4-Regular text-secondary mb-4">Silakan selesaikan pembayaran untuk nomor reservasi <strong>{{ $sewatenant->no_pembayaran }}</strong></p>

        <div class="bg-light p-3 rounded-3 mb-4 text-start font-T4-Regular">
            <div class="d-flex justify-content-between mb-2">
                <span>Tanggal Mulai Sewa:</span>
                <span class="fw-bold">{{ \Carbon\Carbon::parse($sewatenant->tanggal_mulai_sewa)->format('d M Y') }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Tanggal Akhir Sewa:</span>
                <span class="fw-bold">{{ \Carbon\Carbon::parse($sewatenant->tanggal_selesai_sewa)->format('d M Y') }}</span>
            </div>
            <hr class="opacity-25">
            <div class="d-flex justify-content-between">
                <span>Total Bayar:</span>
                <span class="fw-bold text-success fs-5">Rp {{ number_format($sewatenant->harga_sewa_tenant, 0, ',', '.') }}</span>
            </div>
        </div>

        <button id="pay-button" class="btn btn-primary font-T4-SemiBold w-100 py-3 rounded-pill" style="background-color: #238302; border: none;">
            Bayar Sekarang
        </button>

    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Trigger snap popup
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                console.log(result);
                window.location.href = "{{ route('sewa_kios.index') }}";
            },
            onPending: function(result){
                console.log(result);
                window.location.href = "{{ route('sewa_kios.index') }}";
            },
            onError: function(result){
                console.log(result);
                alert("Pembayaran gagal!");
            },
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection
