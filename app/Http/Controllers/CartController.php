<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    public function inde()
    {
        $cart_items =  Cart::where('user_id', '=', Auth::id())->get();
        return response()->json([
            'carts' => $cart_items,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $product = Product::findOrFail($request->product_id);
        $this->cart->add($product,  $request->quantity);

        return response()->json([
            'message' => 'Item added to cart!',

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
