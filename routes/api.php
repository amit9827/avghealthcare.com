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

http://avghealthcare.test:8000/api/menu

Route::get('/menu', [FrontendController::class, 'menu'])->name('menu');



