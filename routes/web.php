<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('vue');
});



Route::get('/{any}', function () {
    return view('vue');
})->where('any', '^(?!admin).*');




Auth::routes();
Route::get('/admin', function () {
    return view('admin.dashboard');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
