<?php

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
    return redirect(route('loan.index'))->with('message', 'Welcome!');
})->name('home');

Route::get('/loans', [App\Http\Controllers\LoanController::class, 'index'])->name('loan.index');
Route::get('/loans/create', [App\Http\Controllers\LoanController::class, 'create'])->name('loan.create');
Route::post('/loans', [App\Http\Controllers\LoanController::class, 'store'])->name('loan.store');
Route::get('/loans/{id}', [App\Http\Controllers\LoanController::class, 'show'])->name('loan.show');
Route::get('/loans/{id}/edit', [App\Http\Controllers\LoanController::class, 'edit'])->name('loan.edit');
Route::put('/loans/{id}', [App\Http\Controllers\LoanController::class, 'update'])->name('loan.update');
Route::delete('/loans/{id}', [App\Http\Controllers\LoanController::class, 'destroy'])->name('loan.destroy');

