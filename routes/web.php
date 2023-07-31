<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TiangController;
use App\Http\Controllers\Admin\PlacementController;

use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Sales\ProspectController;

Route::prefix('sales')->group( function (){
    Route::controller(SalesController::class)->group( function (){
        Route::get('/', 'index')->name('sales');
        
        
        Route::get('/customer/{customer}/edit', 'edit')->name('sales.edit');

        Route::get('/antrian', 'antrian')->name('sales.antrian');

    });

    Route::controller(ProspectController::class)->group( function (){
        Route::get('/prospect', 'index')->name('sales.prospect.index');
        Route::get('/prospect/create', 'create')->name('sales.prospect.create');
        Route::get('/prospect/{id}/detail', 'detail')->name('sales.prospect.detail');
        // Route Post Only //
        Route::post('/prospect/store', 'store');
    });
});

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
        Route::get('/placement/{id}/edit', 'edit');
        // Route Post Only //
        Route::post('/placement/store', 'store');
        Route::post('/placement/edit', 'update');
    });
    Route::controller(TiangController::class)->group( function (){
        Route::get('/tiang', 'index')->name('admin.tiang');
        Route::get('/tiang/create', 'create')->name('admin.tiang.create');
        // Route Post Only //
        Route::post('/tiang/store', 'store');
    });
});


Route::get('/', function(){
    return view('map');
});