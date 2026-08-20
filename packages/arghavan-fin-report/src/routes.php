<?php

use Arghavan\FinReport\Controllers\AllRequestsReportController;
use Arghavan\FinReport\Controllers\MonthlyRequestsReportController;
use Illuminate\Support\Facades\Route;


Route::name('fin-report.')->prefix('fin-report')->middleware(['web', 'auth','access:گزارش مالی'])->group(function () {
    Route::get('all-requests/export', [AllRequestsReportController::class, 'export'])->name('all-requests.export');
    Route::get('all-requests/{case_number}', [AllRequestsReportController::class, 'show'])->name('all-requests.show');
    Route::get('all-requests', [AllRequestsReportController::class, 'index'])->name('all-requests.index');
    Route::post('all-requests/update', [AllRequestsReportController::class, 'update'])->name('all-requests.update');

    Route::get('monthly-requests', [MonthlyRequestsReportController::class, 'report'])->name('monthly-requests.index');
    Route::get('monthly-requests/export', [MonthlyRequestsReportController::class, 'export'])->name('monthly-requests.export');
});
