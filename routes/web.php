<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Models\Etude;
use App\Http\Controllers\PasswordResetController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency('daily'))
        ->add(Url::create('/a-propos')->setPriority(0.8)->setChangeFrequency('monthly'))
        ->add(Url::create('/catalogue')->setPriority(0.9)->setChangeFrequency('weekly'));

    $etudes = Etude::all();
    foreach ($etudes as $etude) {
        $sitemap->add(Url::create("/catalogue/{$etude->slug}-{$etude->id}")
            ->setPriority(0.7)
            ->setChangeFrequency('monthly'));
        }

    return $sitemap->toResponse(request());
});


Route::get('/', [CatalogueController::class, 'home'])->name('home');
Route::get('/a-propos', [CatalogueController::class, 'about'])->name('about');


// API route for sources autocomplete
Route::get('/api/sources', function (Request $request) {
    $term = strtolower($request->query('term')); 
    return \App\Models\Source::whereRaw('LOWER(name) LIKE ?', ["{$term}%"])->get();
});

// Authentication routes
Route::get('/demande', [AuthController::class, 'showDemandeForm'])->name('auth.demande_compte');
Route::post('/demande', [AuthController::class, 'submitDemande'])->name('auth.demande.submit');
Route::get('/demande/validate', [AuthController::class, 'validateDemande'])->name('auth.demande.validate');

Route::get('/password/forgot', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::get('/login', [AuthController::class,'login'])->name('auth.login');
Route::post('/login', [AuthController::class,'doLogin'])->name('auth.doLogin');
Route::delete('/logout', [AuthController::class,'logout'])->name('auth.logout');


// Routes for CatalogueController
Route::prefix('/catalogue')->name('catalogue.')
    ->controller(CatalogueController::class)
    ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/mes-etudes', 'user_tab')->name('user_tab')->middleware('auth');
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
