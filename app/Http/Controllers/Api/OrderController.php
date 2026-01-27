<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, OrderService $service) {
        $order = $service->createOrder($request->all());
        return response()->json($order, 201);
    }
}

