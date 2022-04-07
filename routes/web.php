<?php

use App\Http\Controllers\FinanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentsController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('homepage');

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth:finance']], function () {
    Route::get('finance/dashboard', [FinanceController::class, 'index'])->name('finance.dashboard');
});

Route::post('/payments', [PaymentsController::class, 'store'])->middleware(['auth'])->name('payments.store');

require __DIR__ . '/auth.php';
