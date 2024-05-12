<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\NTNController;
use App\Http\Controllers\SalaryTaxCalculator;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->prefix('/user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

Route::middleware('auth')->prefix('/user/dashboard')->group(function () {
    
    // ntn
    Route::get('/ntn-index', [NTNController::class, 'index'])->name('ntn.index');
    Route::get('/ntn-finder', [NTNController::class, 'finder_index'])->name('ntn.finder_index');
    Route::get('/find-ntn', [NTNController::class, 'Ntn_find']);

    Route::post('/ntn-register', [NTNController::class, 'register']);
    Route::post('/ntn-edit/{id}', [NTNController::class, 'edit']);


    // cart
    Route::get('/cart-index',[CartController::class,'index'])->name('user.cart');
    Route::post('/cart/delete-item/{id}',[CartController::class,'delete']);

    //salary
    Route::get('/salary-cal',[SalaryTaxCalculator::class,'index']);
    Route::get('/salary-tax-calculate',[SalaryTaxCalculator::class,'calculate']);

});
