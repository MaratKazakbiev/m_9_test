<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;


Route::prefix('product')->group(function(){
    Route::post('/create', [ProductController::class, 'create_product']);
    Route::get('/get', [ProductController::class, 'get_product']);
    Route::post('/update', [ProductController::class, 'update_product']);
    Route::post('/delete', [ProductController::class, 'delete_product']);
});

Route::get('/products', [ProductController::class, 'get_products']);
Route::get('/products/limit', [ProductController::class, 'get_limit']);

