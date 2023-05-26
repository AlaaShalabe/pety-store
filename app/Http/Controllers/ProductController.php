<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProduct;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('rates')->withCount('rates')->get();
        return response()->json(['products' => $products]); 
    }
    
    public function store(StoreProduct $request)
    {
        $data = $request->validated();
        $data['image'] = $request->file('image')->store('public/post_images');
        $product = Product::create($data);
        return response()->json([
            'message' => 'Product stored successfully.',
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product->load('rates');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, Product $product)
    {
        $data = $request->validated();
        $data['image']=$request->file('image')->store('public/post_images');
        $product->update($data);
        return response()->json([
            'message' => 'Product updated successfully.',
            'data' => new ProductResource($product),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }
}
