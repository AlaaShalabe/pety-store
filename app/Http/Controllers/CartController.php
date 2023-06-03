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
        $product_id = $request->product_id;
        $quantity = $request->post('quantity', 1);

        if (Auth::check()) {

            $produc_check = Product::where('id', $product_id)->first();

            $item = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->exists();

            if ($item) {
                return response()->json([
                    'message' => $produc_check->name . 'already added to cart!',

                ]);
            }

            $carItem = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'quantity' => $quantity,
            ]);
            return response()->json([
                'message' => $produc_check->name . '  Added to cart!',

            ], 201);
        } else {
            return response()->json([
                'message' =>  'log in to continue!',

            ]);
        }
    }
    // public function store(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'product_id' => 'required|int|exists:products,id',
    //         'quantity' => 'nullable|int|min:1',
    //         'user_id' => 'nullable|numeric|exists:users,id',
    //     ]);
    //     $quantity = $request->post('quantity', 1);
    //     $user = $request->user();
    //     $product = Product::find($request->product_id);
    //     if ($user) {
    //         $cart = Cart::where(['user_id' => $user->id, 'product_id' => $product->id])->exists();
    //         if ($cart) {
    //             $cart->quantity += $quantity;
    //             $cart->save();
    //         } else {
    //             Cart::create([
    //                 'user_id' => Auth::id(),
    //                 'product_id' => $product->id,
    //                 'quantity' => $quantity,
    //             ]);
    //         }
    //         return response()->json([
    //             'message' => 'Item added to cart!',
    //             'cart' => $cart,
    //         ], 201);
    //     } else {
    //     }
    // }

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
