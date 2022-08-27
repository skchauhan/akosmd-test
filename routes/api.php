<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\API\V1\ProductController;

Route::post('login', [RegisterController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function(){
    Route::resource('products', ProductController::class);
});