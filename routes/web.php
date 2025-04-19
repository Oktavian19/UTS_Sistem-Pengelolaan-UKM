<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UkmAdminController;
use App\Http\Controllers\UkmController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'ukm'], function() {  
    Route::get('/', [UkmController::class, 'index']);
    Route::post('/list', [UkmController::class, 'list']);
    Route::get('/create', [UkmController::class, 'create']);
    Route::post('/', [UkmController::class, 'store']);
    Route::group(['prefix' => 'admin'], function() {  
        Route::get('/', [UkmAdminController::class, 'index']);
        Route::post('/list', [UkmAdminController::class, 'list']);
        Route::get('/create', [UkmAdminController::class, 'create']);
        Route::post('/', [UkmAdminController::class, 'store']);
        Route::get('/{id}', [UkmAdminController::class, 'show']);
        Route::get('/{id}/edit', [UkmAdminController::class, 'edit']);
        Route::put('/{id}', [UkmAdminController::class, 'update']);
        Route::get('/{id}/delete', [UkmAdminController::class, 'confirm']); 
        Route::delete('/{id}/delete', [UkmAdminController::class, 'delete']);
    });
    Route::get('/{id}', [UkmController::class, 'show']);
    Route::get('/{id}/edit', [UkmController::class, 'edit']);
    Route::put('/{id}', [UkmController::class, 'update']);
    Route::get('/{id}/delete', [UkmController::class, 'confirm']); 
    Route::delete('/{id}/delete', [UkmController::class, 'delete']);
});

Route::group(['prefix' => 'category'], function() {  
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/list', [CategoryController::class, 'list']);
    Route::get('/create', [CategoryController::class, 'create']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('/{id}', [CategoryController::class, 'show']);
    Route::get('/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('/{id}', [CategoryController::class, 'update']);
    Route::get('/{id}/delete', [CategoryController::class, 'confirm']); 
    Route::delete('/{id}/delete', [CategoryController::class, 'delete']);
});

Route::group(['prefix' => 'admin'], function() {  
    Route::get('/', [AdminsController::class, 'index']);
    Route::post('/list', [AdminsController::class, 'list']);
    Route::get('/create', [AdminsController::class, 'create']);
    Route::post('/', [AdminsController::class, 'store']);
    Route::get('/{id}', [AdminsController::class, 'show']);
    Route::get('/{id}/edit', [AdminsController::class, 'edit']);
    Route::put('/{id}', [AdminsController::class, 'update']);
    Route::get('/{id}/delete', [AdminsController::class, 'confirm']); 
    Route::delete('/{id}/delete', [AdminsController::class, 'delete']);
});