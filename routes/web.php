<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SitemapController;



// Laravel homepage
Route::get('/', function () {
    return view('vue');
});

// Laravel Auth routes
Auth::routes();



Route::get('/phonepe/create-payment/{order_id}', [App\Http\Controllers\PhonePePaymentController::class, 'createPayment'])
    ->name('phonepe.createPayment');

Route::get('/phonepe/verifyPayment/{txn_id}', [App\Http\Controllers\PhonePePaymentController::class, 'verifyPayment'])
    ->name('phonepe.verifyPayment');



    Route::get('/phonepe/callback', [App\Http\Controllers\PhonePePaymentController::class, 'callback'])
    ->name('phonepe.callback');


Route::get('/cod/success/{txn_id}', [App\Http\Controllers\PhonePePaymentController::class, 'cod_success'])
    ->name('cod.success');



Route::get('/order/status/{txn_id}', [App\Http\Controllers\FrontendController::class, 'order_status'])
    ->name('order_status');

Route::post('/checkout', [App\Http\Controllers\FrontendController::class, 'checkout'])
    ->name('checkout');



// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/posts', [DashboardController::class, 'posts'])->name('posts');
        Route::get('/product', [DashboardController::class, 'product'])->name('product');
        Route::get('/products', [DashboardController::class, 'products'])->name('products');
        Route::post('/products', [DashboardController::class, 'product_store'])->name('product_store');
        Route::get('/product/{id}', [DashboardController::class, 'product_get'])->name('product_get');
        Route::get('/product-delete/{id}', [DashboardController::class, 'product_delete'])->name('product_delete');

        Route::get('/categories', [DashboardController::class, 'categories'])->name('categories');
        Route::get('/category', [DashboardController::class, 'category'])->name('category');
        Route::post('/category', [DashboardController::class, 'category_store'])->name('category_store');
        Route::get('/category/{category_id}', [DashboardController::class, 'category_get'])->name('category_get');
        Route::get('/category-delete/{id}', [DashboardController::class, 'category_delete'])->name('category_delete');


        Route::get('/pages', [DashboardController::class, 'pages'])->name('pages');
        Route::get('/page/{id}', [DashboardController::class, 'page_get'])->name('page_get');
        Route::get('/page', [DashboardController::class, 'page'])->name('page');
        Route::post('/pages', [DashboardController::class, 'page_store'])->name('page_store');
        Route::get('/page-delete/{id}', [DashboardController::class, 'page_delete'])->name('page_delete');

        Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
        Route::get('/order/{id}', [DashboardController::class, 'order_get'])->name('order_get');
        Route::get('/order-delete/{id}', [DashboardController::class, 'order_delete'])->name('order_delete');

        Route::get('/customers', [DashboardController::class, 'customers'])->name('customers');
        Route::get('/customer/{id}', [DashboardController::class, 'customer_get'])->name('customer_get');
        Route::get('/customer-delete/{id}', [DashboardController::class, 'customer_delete'])->name('customer_delete');

        Route::get('/ingredients', [DashboardController::class, 'ingredients'])->name('ingredients');
        Route::get('/ingredient', [DashboardController::class, 'ingredient'])->name('ingredient');
        Route::post('/ingredient', [DashboardController::class, 'ingredient_store'])->name('ingredient_store');
        Route::get('/ingredient/{ingredient_id}', [DashboardController::class, 'ingredient_get'])->name('ingredient_get');
        Route::get('/ingredient-delete/{id}', [DashboardController::class, 'ingredient_delete'])->name('ingredient_delete');

        Route::get('/benefits', [DashboardController::class, 'benefits'])->name('benefits');
        Route::get('/benefit', [DashboardController::class, 'benefit'])->name('benefit');
        Route::post('/benefit', [DashboardController::class, 'benefit_store'])->name('benefit_store');
        Route::get('/benefit/{benefit_id}', [DashboardController::class, 'benefit_get'])->name('benefit_get');
        Route::get('/benefit-delete/{id}', [DashboardController::class, 'benefit_delete'])->name('benefit_delete');


        Route::get('/order', [DashboardController::class, 'order'])->name('order');
        Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
        Route::post('/orders', [DashboardController::class, 'order_store'])->name('order_store');
        Route::get('/order/{id}', [DashboardController::class, 'order_get'])->name('order_get');
        Route::post('/order_update/{id}', [DashboardController::class, 'order_update'])->name('order_update');

        Route::get('/rating', [DashboardController::class, 'rating_new'])->name('rating_new');
        Route::get('/ratings', [DashboardController::class, 'ratings'])->name('ratings');
        Route::post('/ratings', [DashboardController::class, 'rating_store'])->name('rating_store');
        Route::get('/rating/{id}', [DashboardController::class, 'rating_get'])->name('rating_get');
        Route::get('/rating-delete/{id}', [DashboardController::class, 'rating_delete'])->name('rating_delete');



    });
});

Route::get('/images/undefined', [DashboardController::class, 'showImageundefined'])
     ->name('image.undefined');

Route::get('/images/{path}', [DashboardController::class, 'showImage'])
     ->where('path', '.*')
     ->name('image.show');

     Route::get('/sitemap.xml', [SitemapController::class, 'index']);
     Route::get('/sitemap-products/{page?}', [SitemapController::class, 'products']);
     Route::get('/sitemap-categories/{page?}', [SitemapController::class, 'categories']);

     Route::get('/sitemap_html', [SitemapController::class, 'index_html'])->name('sitemap_html');
     Route::get('/sitemap_html-products/{page?}', [SitemapController::class, 'products_html'])->name('sitemap_products_html');
     Route::get('/sitemap_html-categories/{page?}', [SitemapController::class, 'categories_html'])->name('sitemap_categories_html');



// Catch-all for Vue, exclude admin
Route::get('/{any}', function () {
    return view('vue');
})->where('any', '^(?!admin)(.*)$');
