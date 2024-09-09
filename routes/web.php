<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
   return redirect()->route('category.index');
   //  return view('index');
});

Route::controller(CategoryController::class)
->prefix('category')->as('category.')->group(function(){
	Route::get('/','index')->name('index');
	Route::post('store','store')->name('store');
});