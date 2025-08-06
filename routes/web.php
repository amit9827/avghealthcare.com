<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!admin).*');



