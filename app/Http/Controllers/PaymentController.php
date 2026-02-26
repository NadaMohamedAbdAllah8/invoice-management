<?php

namespace App\Http\Controllers;

use App\Data\CreatePaymentDTO;
use App\Http\Requests\CreatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    use RespondsWithJson;

    public function __construct(private InvoiceService $invoiceService) {}

    public function store(CreatePaymentRequest $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('recordPayment', [Invoice::class, $invoice]);

        $createPaymentDto = CreatePaymentDTO::fromRequest(request: $request);

        $payment = $this->invoiceService->recordPayment(dto: $createPaymentDto);

        return $this->returnItemWithSuccessMessage(
            item: new PaymentResource($payment),
            message: 'Payment created successfully'
        );
    }
}
