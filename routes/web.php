<?php

use App\Http\Controllers\UkmController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class,'index']);
Route::group(['prefix' => 'ukm'], function() {  
    Route::get('/', [UkmController::class, 'index']);
    Route::post('/list', [UkmController::class, 'list']);
});