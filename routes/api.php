<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function(Request $request){

    return "Hello Api";
});



Route::get('/menu', [FrontendController::class, 'menu'])->name('menu');
Route::get('/config/min_order_amount', [FrontendController::class, 'min_order_amount'])->name('min_order_amount');


