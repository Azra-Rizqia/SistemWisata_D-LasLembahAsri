namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesanTiketPaket;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;

        try {
            $notification = new Notification();
            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;

            $pesanan = PesanTiketPaket::where('kode_pesan_tiket', $orderId)->first();

            if (!$pesanan) return response()->json(['message' => 'Order tidak ditemukan'], 404);

            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $pesanan->update(['status' => 'Selesai']);
            } elseif ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                $pesanan->update(['status' => 'Dibatalkan']);
            }

            return response()->json(['message' => 'Callback Berhasil']);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}