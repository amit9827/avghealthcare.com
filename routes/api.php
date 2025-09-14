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

//from web.php

// Laravel-powered pages
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/category/laravel/{category_slug}', [FrontendController::class, 'category'])->name('category');
Route::get('/ingredients/laravel/{ingredient_slug}', [FrontendController::class, 'ingredients'])->name('ingredients');
Route::get('/product/laravel/{product_slug}', [FrontendController::class, 'product_by_slug'])->name('product_by_slug');
Route::get('/products_featured/laravel', [FrontendController::class, 'products_featured'])->name('products_featured');
Route::get('/category_featured/laravel', [FrontendController::class, 'category_featured'])->name('category_featured');
Route::get('/page/laravel/{page_slug}', [FrontendController::class, 'page_by_slug'])->name('page_by_slug');

Route::get('/images/{path}', [DashboardController::class, 'showImage'])
     ->where('path', '.*')
     ->name('image.show');

