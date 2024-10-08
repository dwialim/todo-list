<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:sanctum');


Route::controller(CategoryController::class)
->prefix('category')->group(function(){
	Route::get('/','getCategory');
});