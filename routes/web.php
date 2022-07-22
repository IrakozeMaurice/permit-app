<?php

use App\Http\Controllers\FinanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/test', function () {
//     return Excel::download(new PaymentExport, 'payments.xlsx');
// });

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/dashboard/sign-contract', [HomeController::class, 'signContract'])->middleware(['auth'])->name('dashboard.sign-contract');
Route::get('/dashboard/claim-contract', [HomeController::class, 'claimContract'])->middleware(['auth'])->name('dashboard.claim-contract');

Route::group(['middleware' => ['auth:finance']], function () {
    Route::get('finance/dashboard', [FinanceController::class, 'index'])->name('finance.dashboard');
    Route::get('finance/dashboard/students', [FinanceController::class, 'showStudents'])->name('finance.students');
    Route::get('finance/dashboard/student/{student}', [FinanceController::class, 'showStudentInfo'])->name('finance.studentInfo');
    Route::get('finance/dashboard/payments', [FinanceController::class, 'showPayments'])->name('finance.payments');

    Route::post('finance/dashboard/payments/approve/{payment}', [FinanceController::class, 'approvePayment'])->name('finance.payments.approve');
    Route::post('finance/dashboard/payments/decline/{payment}', [FinanceController::class, 'declinePayment'])->name('finance.payments.decline');

    Route::get('finance/dashboard/reports/payments', [FinanceController::class, 'showPaymentsReport'])->name('reports.payments');
    Route::get('finance/dashboard/reports/payments/pdf', [FinanceController::class, 'payments_report_pdf'])->name('reports.payments.pdf');
    Route::get('finance/dashboard/reports/payments/excel', [FinanceController::class, 'payments_report_excel'])->name('reports.payments.excel');
    Route::get('finance/dashboard/permit-release', [FinanceController::class, 'showPermitRelease'])->name('finance.dashboard.permit-release');
    Route::post('finance/dashboard/permit-release', [FinanceController::class, 'releasePermit'])->name('finance.dashboard.release-permit');
    Route::get('finance/dashboard/claims', [FinanceController::class, 'showClaims'])->name('finance.dashboard.claims');
    Route::get('finance/dashboard/claims/{student}', [FinanceController::class, 'showStudentClaims'])->name('finance.dashboard.student-claims');
    Route::post('finance/dashboard/permit-release', [FinanceController::class, 'releasePermit'])->name('finance.dashboard.release-permit');
});

Route::post('/payments', [PaymentsController::class, 'store'])->middleware(['auth'])->name('payments.store');
Route::get('/dashboard/permit/pdf', [HomeController::class, 'download_permit'])->middleware(['auth'])->name('dashboard.permit.pdf');
Route::get('/dashboard/contract/pdf', [HomeController::class, 'download_contract'])->middleware(['auth'])->name('dashboard.contract.pdf');

require __DIR__ . '/auth.php';
