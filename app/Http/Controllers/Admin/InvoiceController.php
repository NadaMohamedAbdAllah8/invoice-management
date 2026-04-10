<?php

namespace App\Http\Controllers\Admin;

use App\Data\Invoice\FilterInvoiceDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContractInvoicesRequest;
use App\Http\Resources\Admin\InvoiceResource;
use App\Services\Admin\InvoiceService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class InvoiceController extends Controller
{
    use RespondsWithJson;

    public function __construct(private InvoiceService $invoiceService)
    {
    }

    public function index(ContractInvoicesRequest $request): JsonResponse
    {
        $invoices = $this->invoiceService->findMany(
            dto: FilterInvoiceDto::fromArray($request->validated()),
        );

        return $this->returnPaginatedData(
            item: $invoices,
            message: 'Invoices fetched successfully',
            resourcePath: InvoiceResource::class,
        );
    }

    public function show(int $id): JsonResponse
    {
        $invoice = $this->invoiceService->getOneById(id: $id);

        return $this->returnItemWithSuccessMessage(
            item: new InvoiceResource($invoice),
            message: 'Invoice fetched successfully',
        );
    }
}
