<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'tenant'])->group(function (): void {
    Route::post('/contracts', [ContractController::class, 'store']);
    Route::post('/contracts/{contract}/invoices', [InvoiceController::class, 'store']);
});
