<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return ResponseFormatter::success(
            $product,
            'Data List Produk Berhasil Diambil'
        );
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
        $user = $request->user();
        $image = $request->file('image')->store('product', 'public');

        if ($user->roles == 'admin') {
            $product = Product::create([
                'name' => $request->name,
                'image' => $image,
                'description' => $request->description,
                'price' => $request->price,
                'rate' => $request->rate,
            ]);

            return ResponseFormatter::success($product, 'Produk Berhasil Ditambahkan');
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return ResponseFormatter::success(
                $product,
                'Data Detail Product Berhasil Diambil'
            );
        } else {
            return ResponseFormatter::error([
                'message' => 'Data Tidak Ditemukan',
                'id' => $id
            ], 'Data Tidak Ditemukan', 404);
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
        $user = $request->user();
        $product = Product::find($id);

        if ($user->roles == 'admin') {
            $product->update([
                'name' => $request->name ?? $product->name,
                'description' => $request->description ?? $product->description,
                'price' => $request->price ?? $product->price,
                'rate' => $request->rate ?? $product->rate,
            ]);

            return ResponseFormatter::success($product, 'Produk Berhasil Diupdate');
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
        $product = Product::find($id);

        if ($product) {
            $product->delete();

            return ResponseFormatter::success($product, 'Product Berhasil Dihapus');
        } else {
            return ResponseFormatter::error([
                'message' => 'Data Tidak Ditemukan',
                'id' => $id
            ], 'Data Tidak Ditemukan', 404);
        }
    }
}