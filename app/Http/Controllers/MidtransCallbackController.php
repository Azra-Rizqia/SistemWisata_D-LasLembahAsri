<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesanTiketPaket;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
{
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = false;
    \Log::info('CALLBACK MASUK', $request->all());
    $notif = new \Midtrans\Notification();
    $orderId = $notif->order_id;
    $status = $notif->transaction_status;
    $pesanan = PesanTiketPaket::where('kode_pesan_tiket', $orderId)->first();

    if (!$pesanan) {
        \Log::error('ORDER TIDAK DITEMUKAN', ['order_id' => $orderId]);
        return response()->json(['message' => 'Order tidak ditemukan'], 404);
    }

    if ($status == 'settlement' || $status == 'capture') {
        $pesanan->update(['status' => 'Selesai']);
    } elseif (in_array($status, ['expire', 'cancel', 'deny'])) {
        $pesanan->update(['status' => 'Dibatalkan']);
    }

    return response()->json(['message' => 'OK']);
}
}