<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TiangController;
use App\Http\Controllers\Admin\PlacementController;

Route::prefix('admin')->group( function (){
    Route::controller(AdminController::class)->group( function (){
        Route::get('/', 'index')->name('admin');
    });
    Route::controller(AreaController::class)->group( function (){
        Route::get('/area', 'index')->name('admin.area');
        Route::get('/area/create', 'create')->name('area.create');
        // Route Post Only //
        Route::post('/create/area', 'store');
    });
    Route::controller(PlacementController::class)->group( function (){
        Route::get('/placement', 'index')->name('admin.placement');
        Route::get('/placement/create', 'create')->name('admin.placement.create');
        Route::get('/placement/create/tiangs', 'ambiltiang');
        // Route Post Only //
        Route::post('/placement/store', 'store');
    });
    Route::controller(TiangController::class)->group( function (){
        Route::get('/tiang', 'index')->name('admin.tiang');
        Route::get('/tiang/create', 'create')->name('admin.tiang.create');
        // Route Post Only //
        Route::post('/tiang/store', 'store');
    });
});

Route::prefix('sales')->group( function (){
    Route::controller(SalesController::class)->group( function (){
        Route::get('/', 'index');
        Route::get('/customer', 'complate')->name('sales.index');
        Route::get('/customer/create', 'createview')->name('sales.create');
        Route::get('/customer/{customer}/edit', 'edit')->name('sales.edit');
        Route::get('/customer/{customer}/melengkapi', 'melengkapi')->name('sales.melengkapi');
        Route::get('/antrian', 'antrian')->name('sales.antrian');
        // Route Post Only //
        Route::post('/create/customer', 'create');
    });
});