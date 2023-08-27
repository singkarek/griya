<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ModemController;
use App\Http\Controllers\Admin\TiangController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\Admin\Area\AreaController;

use App\Http\Controllers\Sales\CustomersController;

use App\Http\Controllers\Teknisi\TeknisiController;
use App\Http\Controllers\Oprasional\AntrianController;
use App\Http\Controllers\Admin\Area\SplitterController;
use App\Http\Controllers\Admin\Area\TiangAreaController;
use App\Http\Controllers\Oprasional\OprasionalController;


Route::middleware('guest')->group(function (){
    Route::controller(LoginController::class)->group(function (){
        Route::get('/login','index')->name('login');
        // Route Post Only //
        Route::post('/login','authenticate');
    });
});

Route::middleware('auth')->group(function (){
    Route::controller(LoginController::class)->group(function (){
        // Route Post Only //
        Route::post('/logout','logout');
    });
});


Route::middleware('admin')->group(function (){
    Route::prefix('oprasional')->group(function (){
        Route::controller(OprasionalController::class)->group(function (){
            Route::get('/', 'index');
            Route::get('/allpsb', 'allPsb');
            Route::get('/allcustomers', 'allCusttomer');
            Route::get('/regist', 'regist');
            Route::get('/regist/{pppoe_secret}/detail', 'registDetail');
            // Route Post Only //
            Route::post('/done/{pppoe_secret}', 'doneCustomer');
            Route::post('/regist/store', 'registStore');
        });
            Route::prefix('antrian')->group(function (){
                Route::controller(AntrianController::class)->group(function (){
                    Route::get('/requestvalidasi', 'requestvalidasi');
                    Route::get('/requestvalidasi/{ppoe_id}/edit', 'riviewValidasi');
                    Route::get('/payment', 'waitList');
                    // Route::get('/waitantrian', 'waitaAtrian');
                    Route::get('/penjadwalan', 'penjadwalan');
                    Route::get('/jalur/{pppoe_secret}/edit', 'jalur');
                    // Route Post Only //
                    Route::post('/jalur/store', 'jalurStore');
                    Route::post('/validasireq', 'validasiReq');
                    Route::post('/penjadwalan', 'penjadwalanUpdate');
            
            });
        });
    });
});

Route::middleware('teknisi')->group(function (){
    Route::prefix('teknisi')->group(function (){
        Route::controller(TeknisiController::class)->group(function (){
            Route::get('/', 'index');
            Route::get('/{pppoe_secret}/penarikan', 'penarikan');
            Route::get('/{pppoe_secret}/ajukanreg', 'ajukanreg');
            Route::get('/{pppoe_secret}/show', 'show');
        });
    });
});

Route::middleware('sales')->group(function (){
    Route::prefix('sales')->group(function (){
        Route::controller(SalesController::class)->group(function (){
            Route::get('/', 'index');
            Route::get('/prosespemasangan', 'prosesPemasangan');
            Route::get('/maps-access', 'mapsAccess');
            // Route Post Only //
            Route::post('/uncover', 'uncover');
        });
        Route::prefix('customers')->group(function (){
            Route::controller(CustomersController::class)->group(function (){
                Route::get('/', 'index');
                Route::get('/create', 'create');
                Route::get('/surveyadmin', 'surveyAdmin');
                Route::get('/{id}/detail', 'detail');
                Route::get('/fotorumah/{id}/edit', 'editFotoRumah');
                Route::get('/koordinat/{id}/edit', 'editKoordinat');
                Route::get('/access/{id}/edit', 'editAccess');
                Route::get('/jalur/{id}/edit', 'editJalur');
                // Route Post Only //
                Route::post('/store', 'store');
                Route::post('/jalur/store', 'jalurStore');
                Route::post('/pengajuan/{id}', 'pengajuanPasang');
                // Route Put Only //
                Route::put('/koordinat', 'updateKoordinat');
                Route::put('/access', 'updateAccess');

            });
        });
    });
});


Route::middleware('admin')->group(function (){
    Route::prefix('admin')->name('admin.')->group(function (){
        Route::controller(AdminController::class)->group(function (){
            Route::get('/', 'index')->name('index');
        });

        Route::prefix('modem')->group(function (){
            Route::controller(ModemController::class)->group(function (){
                Route::get('/', 'index');
                Route::get('/create', 'create');
                // Route Post Only //
                Route::post('/store', 'store');
            });
        });

        Route::prefix('tiang')->name('tiang.')->group(function (){
            Route::controller(TiangController::class)->group(function (){
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/transfertiang', 'transfertiang')->name('transfertiang');
                // Route Post Only //
                Route::post('/store', 'store');
                Route::post('/tes', 'tes');
            });
        });

        Route::prefix('area')->name('area.')->group(function (){
            Route::controller(AreaController::class)->group(function (){
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                // Route Post Only //
                Route::post('/create', 'store');
            });
            Route::prefix('tiang')->name('placement.')->group(function (){
                Route::controller(TiangAreaController::class)->group(function (){
                    Route::get('/{id}', 'index')->name('index');
                    Route::get('/tiangs/{area}/{type}', 'getTiang');
                    Route::get('/{id}/edit/koordinat', 'editKoordinat');
                    Route::get('/{id}/{type}/tempat', 'createTempat');
                    // Route Post Only //
                    Route::post('/edit/koordinat', 'updateKoordinat');
                    Route::post('/edit/tempat', 'updateTempat');
                });
            });
            Route::prefix('splitter')->name('splitter.')->group(function (){
                Route::controller(SplitterController::class)->group(function (){
                    Route::get('/{area_id}', 'index')->name('index');
                    Route::get('/{place_id}/edit/splitter', 'editSplitter');
                    Route::get('/{place_id}/remove/splitter', 'editRemoveSplitter');
                    // Route Post Only //
                    Route::post('/edit/splitter', 'updateAddSplitter');
                    Route::post('/remove/splitter', 'updateRemoveSplitter');
                });
            });

        });

    });
});


