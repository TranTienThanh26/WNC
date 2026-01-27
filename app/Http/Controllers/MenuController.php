<?php

namespace App\Http\Controllers;

class MenuController extends Controller
{
    public function index() {
        $foods = [
            ['name' => 'Pizza', 'price' => 50000],
            ['name' => 'Hamburger', 'price' => 30000],
            ['name' => 'Trà sữa', 'price' => 25000],
        ];

        return view('menu', compact('foods'));
    }
}
