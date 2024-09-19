<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;

Route::get('/', function () {
    return view('welcome');
});

// API route for sources autocomplete
Route::get('/api/sources', function (Request $request) {
    $term = strtolower($request->query('term')); 
    return \App\Models\Source::whereRaw('LOWER(name) LIKE ?', ["{$term}%"])->get();
});

// Authentication routes
Route::get('/catalogue/demande', [AuthController::class, 'showDemandeForm'])->name('auth.demande_compte');
Route::post('/catalogue/demande', [AuthController::class, 'submitDemande'])->name('auth.demande.submit');
Route::get('/catalogue/demande/validate', [AuthController::class, 'validateDemande'])->name('auth.demande.validate');

Route::get('/login', [AuthController::class,'login'])->name('auth.login');
Route::post('/login', [AuthController::class,'doLogin'])->name('auth.doLogin');
Route::delete('/logout', [AuthController::class,'logout'])->name('auth.logout');

// Routes for CatalogueController
Route::prefix('/catalogue')->name('catalogue.')
    ->controller(CatalogueController::class)
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/mes-etudes', 'user_tab')->name('user_tab')->middleware('auth');
        Route::get('/a-propos', 'about')->name('about');
        Route::get('/{slug}-{etude}', 'find')
            ->where([
                'etude'=>'[0-9]+',
                'slug'=> '[a-z0-9/-]+',
            ])->name('find');
        Route::delete('/{etude}', 'destroy')->name('destroy')->middleware('auth');
    });

// Routes for FormController
Route::prefix('/catalogue')->name('catalogue.')
    ->controller(FormController::class)
    ->group(function() {
        Route::get('/new', 'create')->name('create')->middleware('auth');
        Route::post('/new', 'store')->name('store')->middleware('auth');
        Route::get('/{etude}/edit', 'edit')->name('edit')->middleware('auth');
        Route::post('/{etude}/edit', 'update')->middleware('auth');
    });
