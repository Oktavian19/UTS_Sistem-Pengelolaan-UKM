<?php

use App\Http\Controllers\UkmController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'ukm'], function() {  
    Route::get('/', [UkmController::class, 'index']);
    Route::post('/list', [UkmController::class, 'list']);
    Route::get('/create', [UkmController::class, 'create']);
    Route::post('/', [UkmController::class, 'store']);
    Route::get('/{id}', [UkmController::class, 'show']);
    Route::get('/{id}/edit', [UkmController::class, 'edit']);
    Route::put('/{id}', [UkmController::class, 'update']);
    Route::get('/{id}/delete', [UkmController::class, 'confirm']); 
    Route::delete('/{id}/delete', [UkmController::class, 'delete']);
});