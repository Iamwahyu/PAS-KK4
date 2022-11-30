<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Tracking;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->roles === 'admin') {
            $transaction = Transaction::with(['user', 'product', 'tracking'])->get();

            return ResponseFormatter::success($transaction, 'Data Transaksi Berhasil Diambil');
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();

        if ($user->roles === 'admin') {
            $transaction = Transaction::with(['user', 'product', 'tracking'])->find($id);

            return ResponseFormatter::success($transaction, 'Data Transaksi Berhasil Diambil');
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if ($user->roles === 'admin') {
            $transaction = Transaction::find($id);

            $transaction->update([
                'status' => 'SUCCESS'
            ]);

            $tracking = Tracking::create([
                'transaction_id' => $id,
                'description' => 'Pesanan Dikirim',
                'status' => 'SUCCESS',
            ]);

            return ResponseFormatter::success([
                'transaction' => $transaction,
                'tracking' => $tracking,
            ], 'Transaksi Berhasil Diupdate');
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}