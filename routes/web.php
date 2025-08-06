<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;




Route::get('/', function () {
    return view('vue');
});




Auth::routes();



Route::get('/home', [HomeController::class, 'index'])->name('home');






Route::prefix('admin')->name('admin.')->group(function () {




    Route::middleware(['auth'])->group(function () {

        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin');
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        // Add more admin routes here (e.g., /admin/profile)
    });
});


Route::get('/{any}', function () {
    return view('vue');
})->where('any', '^(?!admin).*');

