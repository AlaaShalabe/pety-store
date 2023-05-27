<?php

namespace App\Http\Controllers;

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
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['nullable', 'int', 'min:1'],
        ]);

        $product = Product::find($request->product_id);

        $this->cart->add($product, $request->quantity);
        return response()->json([
            'message' => 'Item added to cart!',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1'],
        ]);

        $this->cart->update($id, $request->post('quantity'));
    }


    public function destroy($id)
    {
        $this->cart->delete($id);

        return [
            'message' => 'Item deleted!',
        ];
    }
}
