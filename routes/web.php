<?php

use App\Models\Invoice;
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

// Dashboard
Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Invoices
Route::middleware(['auth:sanctum', 'verified'])->get('/invoice/create', function() {
    return view('invoice.create');
})->name('invoice.create');

Route::middleware(['auth:sanctum', 'verified'])->get('/invoice', function() {
    return view('invoice.index');
})->name('invoice.index');

Route::middleware(['auth:sanctum', 'verified'])->middleware('can:edit-invoice,invoice')->get('/invoice/edit/{invoice}', function(Invoice $invoice) {
    return view('invoice.edit')->with('invoice', $invoice);
})->name('invoice.edit');

// Settings
Route::middleware(['auth:sanctum', 'verified'])->get('/activity', function() {
    return view('activity.show');
})->name('activity.show');

// Expenses
Route::middleware(['auth:sanctum', 'verified'])->get('/expenses', function() {
    return view('expenses.index');
})->name('expenses.index');

Route::middleware(['auth:sanctum', 'verified'])->get('/expenses/create', function() {
    return view('expenses.create');
})->name('expenses.create');
