<?php

namespace App\Http\Controllers;

use App\Data\CreateInvoiceDTO;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Services\InvoiceService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    use RespondsWithJson;

    public function __construct(private InvoiceService $invoiceService) {}

    public function store(CreateInvoiceRequest $request): JsonResponse
    {
        $createInvoiceDto = CreateInvoiceDTO::fromRequest($request);

        $invoice = $this->invoiceService->createOne($createInvoiceDto);

        return $this->returnItemWithSuccessMessage(
            item: new InvoiceResource($invoice),
            message: 'Invoice created successfully'
        );
    }
}
