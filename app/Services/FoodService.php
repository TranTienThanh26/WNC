<?php

namespace App\Services;

use App\Models\Food;

class FoodService
{
    public function getAll() {
        return Food::all();
    }

    public function create($data) {
        return Food::create($data);
    }
}
