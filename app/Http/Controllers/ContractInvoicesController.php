<?php

namespace App\Http\Controllers;

use App\Data\Invoice\FilterInvoiceDto;
use App\Http\Requests\ContractInvoicesRequest;
use App\Http\Resources\ContactInvoiceResource;
use App\Services\InvoiceService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class ContractInvoicesController extends Controller
{
    use RespondsWithJson;

    public function __construct(private InvoiceService $invoiceService) {}

    public function __invoke(ContractInvoicesRequest $request): JsonResponse
    {
        $filterInvoiceDto = FilterInvoiceDto::fromRequest(request: $request);

        $invoices = $this->invoiceService->findMany(dto: $filterInvoiceDto);

        return $this->returnPaginatedData(
            item: $invoices,
            message: 'Contract invoices fetched successfully',
            resourcePath: ContactInvoiceResource::class,
        );
    }
}
