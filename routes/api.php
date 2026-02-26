<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractInvoicesController;
use App\Http\Controllers\ContractSummaryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'tenant'])->group(function (): void {
    Route::post('/contracts', [ContractController::class, 'store']);
    Route::get('/contracts/{contract}/summary', ContractSummaryController::class);

    Route::post('/contracts/{contract}/invoices', [InvoiceController::class, 'store']);
    Route::get('/contracts/{contract}/invoices', ContractInvoicesController::class);

    Route::post('/invoices/{invoice}/payments', [PaymentController::class, 'store']);

    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show']);
});
