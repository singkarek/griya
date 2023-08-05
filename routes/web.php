<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TiangController;
use App\Http\Controllers\Sales\SalesController;

use App\Http\Controllers\Admin\BackboneController;
use App\Http\Controllers\Sales\ProspectController;
use App\Http\Controllers\Admin\PlacementController;

Route::prefix('sales')->name('sales.')->group( function (){
    Route::controller(SalesController::class)->group( function (){
        Route::get('/', 'index')->name('index');
        Route::get('/antrian', 'antrian')->name('antrian');
    });

    Route::prefix('prospect')->name('prospect.')->group( function (){
        Route::controller(ProspectController::class)->group( function (){
            // Route Get Only //
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/{id}/detail', 'detail')->name('detail');
            Route::get('/updateKoordinat/{id}/edit', 'editKoordinat')->name('editKoordinat');
            // Route Post Only //
            Route::post('/store', 'store');
            // Route Put Only //
            Route::put('/updateKoordinat', 'updateKoordinat');

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
    });
    Route::prefix('placement')->name('placement.')->group( function (){
        Route::controller(PlacementController::class)->group( function (){
            // Route Get Only //
            Route::get('/{id}', 'index')->name('index');
            // Route::get('/create', 'create')->name('create');
            Route::get('/tiangs/{area}/{type}', 'getTiang');
            Route::get('/{id}/edit/koordinat', 'editKoordinat');
            Route::get('/{id}/{type}/tempat', 'createTempat');
            // Route Post Only //
            Route::post('/edit/koordinat', 'updateKoordinat');
            Route::post('/edit/tempat', 'updateTempat');
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


// Route::get('/', function(){
//     return view('map');
// });