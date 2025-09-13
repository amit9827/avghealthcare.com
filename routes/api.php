<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\PhonePePaymentController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function(Request $request){

    return "Hello Api";
});



Route::get('/menu', [FrontendController::class, 'menu'])->name('menu');
Route::get('/config/min_order_amount', [FrontendController::class, 'min_order_amount'])->name('min_order_amount');
Route::get('/order/detail/{txn_id}', [FrontendController::class, 'order_detail'])->name('order_detail');


Route::post('/phonepe/success/{txn_id}', [App\Http\Controllers\PhonePePaymentController::class, 'success'])
    ->name('phonepe.success');
    Route::get('/phonepe/success/{txn_id}', [App\Http\Controllers\PhonePePaymentController::class, 'success'])
    ->name('phonepe.success_get');
