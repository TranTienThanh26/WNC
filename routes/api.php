<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FoodController;

Route::get('/foods', [FoodController::class, 'index']);
