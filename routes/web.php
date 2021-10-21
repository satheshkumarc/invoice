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
    return redirect('invoice');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/invoice', [App\Http\Controllers\InvoiceController::class, 'index']);
Route::post('/invoice', [App\Http\Controllers\InvoiceController::class, 'store']);
Route::get('/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'edit']);
Route::put('/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'update']);
Route::delete('/invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'destroy']);

Route::get('/invoice-mail/{id}', [App\Http\Controllers\InvoiceController::class, 'mail']);
