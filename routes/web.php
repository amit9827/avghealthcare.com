<?php





use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;

// Laravel homepage
Route::get('/', function () {
    return view('vue');
});

// Laravel Auth routes
Auth::routes();

// Laravel-powered pages
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/category/laravel/{category_slug}', [FrontendController::class, 'category'])->name('category');
Route::get('/product/laravel/{product_slug}', [FrontendController::class, 'product_by_slug'])->name('product_by_slug');


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

        Route::get('/categories', [DashboardController::class, 'categories'])->name('categories');
        Route::get('/category', [DashboardController::class, 'category'])->name('category');
        Route::post('/category', [DashboardController::class, 'category_store'])->name('category_store');
        Route::get('/category/{category_id}', [DashboardController::class, 'category_get'])->name('category_get');




    });
});

Route::get('/images/{path}', [DashboardController::class, 'showImage'])
     ->where('path', '.*')
     ->name('image.show');


// Catch-all for Vue, exclude admin
Route::get('/{any}', function () {
    return view('vue');
})->where('any', '^(?!admin)(.*)$');
