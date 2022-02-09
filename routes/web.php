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
    return redirect(route('get.loan.index'))->with('message', 'Welcome!');
})->name('home');

Route::get('/loans', [App\Http\Controllers\LoanController::class, 'index'])->name('get.loan.index');
Route::get('/loans/create', [App\Http\Controllers\LoanController::class, 'create'])->name('get.loan.create');
Route::post('/loans', [App\Http\Controllers\LoanController::class, 'store'])->name('post.loan');
Route::get('/loans/{id}', [App\Http\Controllers\LoanController::class, 'show'])->name('get.loan.show');
Route::get('/loans/{id}/edit', [App\Http\Controllers\LoanController::class, 'edit'])->name('get.loan.edit');
Route::put('/loans/{id}', [App\Http\Controllers\LoanController::class, 'update'])->name('put.loan');
Route::delete('/loans/{id}', [App\Http\Controllers\LoanController::class, 'destroy'])->name('delete.loan');

