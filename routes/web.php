<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/catalogue')->name('catalogue.')->controller(CatalogueController::class)->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/new','create')->name('create');
    Route::get('/{etude}/edit','edit')->name('edit');
    Route::post('/{etude}/edit','update');
    Route::post('/new','store')->name('store');
    Route::get('/{slug}-{etude}', 'find')->where([
        'etude'=>'[0-9]+',
        'slug'=> '[a-z0-9/-]+',
    ])->name('find');


});