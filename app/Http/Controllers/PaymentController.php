<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequset;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function pay(PaymentRequset $request)
    {

        $data = $request->validated();
        $order = Order::where('id', '=', $request->order_id)->first();
        $data['number'] = Hash::make($request->number);
        $payment = Payment::create($data);
        $payment->status = 'completed';
        $payment->save();
        $order->status = 'completed';
        $order->save();


        return response()->json([
            'status' => 'success',
            'payment' => $payment,
            'order' => $order
        ]);
    }
}
