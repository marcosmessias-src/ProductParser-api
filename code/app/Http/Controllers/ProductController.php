<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $products = Product::paginate($perPage);

        if(!$products){
            return response()->json(['message' => 'Nenhum produto cadastrado'], 404);
        }

        return response()->json($products);
    }

    /**
     * Search the specified resource from storage.
     */
    public function search($query)
    {
        $products = Product::search($query)->get();

        if (!$products) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        return response()->json($products);
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $code)
    {
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $product->update($request->all());

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($code)
    {
        $product = Product::where('code', $code)->first();

        if (!$product) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $product->update(['status' => 'trash']);

        return response()->json(['message' => 'Produto movido para lixeira']);
    }
}
