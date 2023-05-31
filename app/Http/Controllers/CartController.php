<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        $carts = $this->cart->get();
        return response()->json([
            'carts' => $carts,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
            'user_id' => 'nullable|numeric|exists:users,id',
        ]);
        $product = Product::find($request->product_id);
        $carts = $this->cart->add($product, $request->quantity);
        return response()->json([
            'message' => 'Item added to cart!',
            'cart' => $carts,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1'],
        ]);

        $this->cart->update($id, $request->quantity);
        return response()->json([
            'message' => 'Item updated!',
        ]);
    }


    public function destroy($id)
    {
        $this->cart->delete($id);

        return response()->json([
            'message' => 'Item deleted!',
        ]);
    }
}
