<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;

Route::prefix('sales')->group( function (){
    Route::controller(SalesController::class)->group( function (){
        Route::get('/', 'index');
        Route::get('/customer/complate', 'complate')->name('sales.complate');
        Route::get('/customer/create', 'createview')->name('sales.create');
        Route::get('/customer/{customer}/edit', 'edit')->name('sales.edit');
        Route::get('/customer/{customer}/melengkapi', 'melengkapi')->name('sales.melengkapi');
        Route::get('/antrian', 'antrian')->name('sales.antrian');
        // Route Post Only //
        Route::post('/create/customer', 'create');
    });
});