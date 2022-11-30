<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $prodct = Product::all();

        return ResponseFormatter::success(
            $prodct,
            'Data List Produk Berhasil Diambil'
        );
    }

    public function show($id)
    {
        $prodct = Product::find($id);

        if ($prodct) {
            return ResponseFormatter::success(
                $prodct,
                'Data Detail Produk Berhasil Diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data Produk Tidak Ada',
                404
            );
        }
    }
}