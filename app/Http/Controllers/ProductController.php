<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProduct;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('isAdmin', ['except' => ['index', 'show']]);
    }
    public function index()
    {
        $products = Product::paginate(8)->with('rates')->withCount('rates')->get();
        return response()->json(['products' => $products]);
    }

    public function store(StoreProduct $request)
    {
        $data = $request->validated();
        $slug = $request->name;
        $data['image'] = $request->file('image')->store('public/post_images');
        $data['slug'] = Str::slug($slug);
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
        $data['image'] = $request->file('image')->store('public/post_images');
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
