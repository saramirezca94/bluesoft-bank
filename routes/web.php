<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\TransactionController;

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
});

Route::get('/dashboard', function () {
    $user = Auth::user()->load('bankAccounts');
    return view('dashboard', compact('user'));
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('bank-accounts', BankAccountController::class)->middleware(['auth']);
Route::post('withdrawal', [TransactionController::class, 'saveWithdrawal'])->middleware(['auth'])->name('make-withdrawal');
Route::post('deposit', [TransactionController::class, 'saveDeposit'])->middleware(['auth'])->name('make-deposit');
Route::get('statement/{accountId}/{month}', [TransactionController::class, 'getStatement'])->middleware(['auth'])->name('statement');
Route::get('latest-transactions/{accountId}', [TransactionController::class, 'getLatestTransactions'])->middleware(['auth'])->name('latest-transactions');
Route::get('reports/', [ReportController::class, 'index'])->middleware(['auth'])->name('reports');
Route::get('clients-transactions/{month}', [ReportController::class, 'getClientTransactionsCount'])->middleware(['auth'])->name('clients-transactions');
Route::get('clients-withdrawals', [ReportController::class, 'getWithdrawalsOutOfCity'])->middleware(['auth'])->name('clients-withdrawals');