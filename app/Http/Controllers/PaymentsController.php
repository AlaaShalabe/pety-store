<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        return [
            'order' => $order
        ];
    }
}
