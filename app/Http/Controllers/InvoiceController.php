<?php

namespace App\Http\Controllers;

use App\Data\CreateInvoiceDTO;
use App\Http\Requests\CreateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Contract;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    use RespondsWithJson;

    public function __construct(private InvoiceService $invoiceService) {}

    public function store(CreateInvoiceRequest $request, Contract $contract): JsonResponse
    {
        $createInvoiceDto = CreateInvoiceDTO::fromRequestWithContract(request: $request, contract: $contract);

        $invoice = $this->invoiceService->createOne(dto: $createInvoiceDto);

        return $this->returnItemWithSuccessMessage(
            item: new InvoiceResource($invoice),
            message: 'Invoice created successfully'
        );
    }

    public function show(Invoice $invoice): JsonResponse
    {
        return $this->returnItemWithSuccessMessage(
            item: new InvoiceResource($invoice->load('contract', 'payments')),
            message: 'Invoice fetched successfully'
        );
    }
}
