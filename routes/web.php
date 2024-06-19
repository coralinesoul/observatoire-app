<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\AuthController;
use App\Livewire\FilterComponent;

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

Route::get('/login', [AuthController::class,'login'])-> name('auth.login');
Route::delete('/logout', [AuthController::class,'logout'])-> name('auth.logout');
Route::post('/login', [AuthController::class,'doLogin']);


Route::prefix('/catalogue')->name('catalogue.')->controller(CatalogueController::class)->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/new','create')->name('create')->middleware('auth');
    Route::get('/{etude}/edit','edit')->name('edit')->middleware('auth');
    Route::post('/{etude}/edit','update')->middleware('auth');
    Route::post('/new','store')->name('store');
    Route::get('/{slug}-{etude}', 'find')->where([
        'etude'=>'[0-9]+',
        'slug'=> '[a-z0-9/-]+',
    ])->name('find');


});
Route::get('/filter-component', FilterComponent::class);