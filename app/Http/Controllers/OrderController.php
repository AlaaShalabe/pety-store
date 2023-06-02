<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use App\Repositories\CartRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Exception\InvalidOrderException;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'user_id' => 'required|numeric|exists:users,id',
        ]);

        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException('Cart is empty');
        }
        $items = $cart->get()->groupBy('cart.cart_id')->all();
        DB::beginTransaction();
        try {
            foreach ($items as  $cart_items) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                ]);
                foreach ($cart_items as $item) {
                    $orderItem = OrderItems::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'total_price' => $cart->total(),
                        'amount' => $item->quantity,
                    ]);
                }
            }
            $orderItem = OrderItems::where('order_id', '=', $order->id)->get();
            $total =  $orderItem->sum('total_price');
            $order->total_price = $total;
            $order->save();
            $cart->empty();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json([
            'msg' => 'created order ',
            'order' => $order,
            'orderItem' => $orderItem
        ], 200);
    }
}
