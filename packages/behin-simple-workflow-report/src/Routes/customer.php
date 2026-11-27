<?php

use Behin\SimpleWorkflowReport\Controllers\Core\CustomersReportController;
use BehinInit\App\Http\Middleware\Access;
use Illuminate\Support\Facades\Route;

Route::name('customers.')->prefix('customers')->middleware(['web', 'auth'])->group(function () {
    Route::get('customers/export', [CustomersReportController::class, 'export'])->name('export');
    Route::get('index', [CustomersReportController::class, 'index'])->name('index');
    Route::post('store', [CustomersReportController::class, 'store'])->name('store');
    Route::put('update', [CustomersReportController::class, 'update'])->name('update');
    Route::delete('destroy', [CustomersReportController::class, 'destroy'])->name('destroy');
});
