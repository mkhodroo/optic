<?php

use Behin\SimpleWorkflowReport\Controllers\Core\CustomersReportController;
use BehinInit\App\Http\Middleware\Access;
use Illuminate\Support\Facades\Route;

Route::name('customers.')->prefix('customers')->middleware(['web', 'auth'])->group(function () {
    Route::get('export', [CustomersReportController::class, 'export'])
        ->middleware(Access::class . ':خروجی اکسل مشتریان')
        ->name('export');
    Route::get('index', [CustomersReportController::class, 'index'])
        ->middleware(Access::class . ':گزارش مشتریان')
        ->name('index');
    Route::get('show/{customer}', [CustomersReportController::class, 'show'])
        ->middleware(Access::class . ':گزارش مشتریان')
        ->name('show');
    Route::post('store', [CustomersReportController::class, 'store'])
        ->middleware(Access::class . ':گزارش مشتریان')
        ->name('store');
    Route::put('update/{customer}', [CustomersReportController::class, 'update'])
        ->middleware(Access::class . ':گزارش مشتریان')
        ->name('update');
    Route::delete('destroy/{customer}', [CustomersReportController::class, 'destroy'])
        ->middleware(Access::class . ':گزارش مشتریان')
        ->name('destroy');
    Route::get('disable/{customer}', [CustomersReportController::class, 'disable'])
        ->middleware(Access::class . ':گزارش مشتریان')
        ->name('disable');
    Route::get('enable/{customer}', [CustomersReportController::class, 'enable'])
        ->middleware(Access::class . ':گزارش مشتریان')
        ->name('enable');
});
