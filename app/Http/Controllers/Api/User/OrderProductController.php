<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = $request->user();
        $product = Product::find($id);

        if ($product) {
            
                $order = Transaction::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'total' => $product->price * $request->quantity,
                    'name' => $user->name,
                    'email' => $user->email,
                    'address' => $user->address,
                    'phone' => $user->phone,
                    'total_price' => $product->price * $request->quantity,
                    'status' => 'PENDING',
                ]);

                return ResponseFormatter::success($order, 'Order Berhasil');
           
        } else {
            return ResponseFormatter::error(
                null,
                'Makanan Tidak Ada',
                404
            );
        }
    }
}