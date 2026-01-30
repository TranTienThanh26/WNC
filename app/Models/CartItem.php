<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id', 'food_id', 'quantity', 'price'
    ];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
