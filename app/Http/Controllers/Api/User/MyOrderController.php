<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Tracking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function index()
    {


        $order = Transaction::with(['product', 'tracking'])->where('user_id',  Auth::user()->id)->get();

        return ResponseFormatter::success($order, 'Data Order Berhasil Diambil');
    }

    public function processPaymentOrder(Request $request)
    {
        $image = $request->file('image')->store('payment', 'public');


        $payment = Payment::create([
            'user_id' => Auth::user()->id,
            'transaction_id' => $request->transaction_id,
            'image' => $image,
            'name' => $request->name,
            'type' => $request->type,
        ]);


        Transaction::where('id', $request->transaction_id)->update([
            'status' => 'WAITING'
        ]);

        $tracking = Tracking::create([
            'transaction_id' => $request->transaction_id,
            'description' => 'Menunggu Pembayaran',
            'status' => 'WAITING',
        ]);

        return ResponseFormatter::success([
            'payment' => $payment,
            'tracking' => $tracking,
        ], 'Pembayaran Berhasil');
    }
}