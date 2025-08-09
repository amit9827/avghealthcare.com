<?php





use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;

// Laravel homepage
Route::get('/', function () {
    return view('vue');
});

// Laravel Auth routes
Auth::routes();

// Laravel-powered pages
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/category/laravel/{category_slug}', [FrontendController::class, 'category'])->name('category');


// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin');
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/posts', [App\Http\Controllers\Admin\DashboardController::class, 'posts'])->name('posts');
    });
});

// Catch-all for Vue, exclude admin
Route::get('/{any}', function () {
    return view('vue');
})->where('any', '^(?!admin)(.*)$');
