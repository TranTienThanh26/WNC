<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;

class OrderService
{
    public function createOrder($data) {
        $order = Order::create([
            'customer_name' => $data['customer_name'],
            'total_price' => 0
        ]);

        $total = 0;

        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['quantity'];

            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $item['food_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        $order->update(['total_price' => $total]);

        return $order->load('items');
    }
}
