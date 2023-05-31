<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function result(Request $request)
    {
        $query = $request->get('query');
        $product = Product::where('name', 'LIKE', '%' . $query . '%')->orWhere('description', 'LIKE', '%' . $query . '%')->get();
        if (count($product) > 0)
            return response()->json([
                'message' => 'Product retrived successfully.',
                'data' => ProductResource::collection($product->load('rates')),
            ]);
        else return response()->json([
            'message' => 'No Details found. Try to search again !',
        ]);
    }
}
