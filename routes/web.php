<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TiangController;
use App\Http\Controllers\Sales\SalesController;

use App\Http\Controllers\Admin\Area\AreaController;
use App\Http\Controllers\Admin\Area\TiangAreaController;
use App\Http\Controllers\Admin\Area\SplitterController;

use App\Http\Controllers\Admin\BackboneController;
use App\Http\Controllers\Sales\CustomersController;

Route::prefix('sales')->name('sales.')->group( function (){
    Route::controller(SalesController::class)->group( function (){
        Route::get('/', 'index')->name('index');
        Route::get('/antrian', 'antrian')->name('antrian');
        Route::get('/maps-access', 'mapsAccess');
    });

    Route::prefix('customers')->group( function (){
        Route::controller(CustomersController::class)->group( function (){
            // Route Get Only //
            Route::get('/', 'index');
            Route::get('/create', 'create');
            // Route::get('/{id}/detail', 'detail');
            Route::get('/fotorumah/{id}/edit', 'editFotoRumah');
            Route::get('/koordinat/{id}/edit', 'editKoordinat');
            Route::get('/access/{id}/edit', 'editAccess');
            Route::get('/jalur/{id}/edit', 'editJalur');
            // Route Post Only //
            Route::post('/store', 'store');
            // Route Put Only //
            Route::put('/koordinat', 'updateKoordinat');
            Route::put('/access', 'updateAccess');

        });
    });
});

Route::prefix('admin')->name('admin.')->group( function (){
    Route::controller(AdminController::class)->group( function (){
        Route::get('/', 'index')->name('index');
    });
    Route::prefix('backbone')->name('backbone.')->group( function (){
        Route::controller(BackboneController::class)->group( function (){
            Route::get('/', 'index')->name('index');
        });
    });
    Route::prefix('area')->name('area.')->group( function (){
        Route::controller(AreaController::class)->group( function (){
            // Route Get Only //
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            // Route Post Only //
            Route::post('/create', 'store');
        });
        Route::prefix('tiang')->name('placement.')->group( function (){
            Route::controller(TiangAreaController::class)->group( function (){
                // Route Get Only //
                Route::get('/{id}', 'index')->name('index');
                Route::get('/tiangs/{area}/{type}', 'getTiang');
                Route::get('/{id}/edit/koordinat', 'editKoordinat');
                Route::get('/{id}/{type}/tempat', 'createTempat');
                // Route Post Only //
                Route::post('/edit/koordinat', 'updateKoordinat');
                Route::post('/edit/tempat', 'updateTempat');
            });
        });
        Route::prefix('splitter')->name('splitter.')->group( function (){
            Route::controller(SplitterController::class)->group( function (){
                Route::get('/{area_id}', 'index')->name('index');
                Route::get('/{place_id}/edit/splitter', 'editSplitter');
                Route::get('/{place_id}/remove/splitter', 'editRemoveSplitter');
                // Route Post Only //
                Route::post('/edit/splitter', 'updateAddSplitter');
                Route::post('/remove/splitter', 'updateRemoveSplitter');
            });
        });
    });

    Route::prefix('tiang')->name('tiang.')->group( function (){
        Route::controller(TiangController::class)->group( function (){
            // Route Get Only //
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/transfertiang', 'transfertiang')->name('transfertiang');
            // Route Post Only //
            Route::post('/store', 'store');
            Route::post('/tes', 'tes');
        });
    });
});
