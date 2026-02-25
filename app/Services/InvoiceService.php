<?php

namespace App\Services;

use App\Data\CreateInvoiceDTO;
use App\Models\Invoice;
use App\Repositories\ContractRepositoryInterface;
use App\Repositories\InvoiceRepositoryInterface;
use App\Validators\InvoiceValidator;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    const REFERENCE_PREFIX = 'INV';

    const REFERENCE_TENANT_ID_PADDING = 3;

    const REFERENCE_SEQUENCE_PADDING = 4;

    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private ContractRepositoryInterface $contractRepository,
        private TaxService $taxService,
    ) {}

    public function createOne(CreateInvoiceDTO $dto): Invoice
    {
        return DB::transaction(function () use ($dto) {
            $contract = $this->contractRepository->getOneById($dto->contract_id);
            InvoiceValidator::throwExceptionIfContractIsInactive(contract: $contract);

            $subtotal = $dto->subtotal;
            $taxAmount = $this->taxService->calculateTotalTax($subtotal);
            $total = $subtotal + $taxAmount;
           
            $dto->tax_amount = $taxAmount;
            $dto->total = $total;

            $dto->invoice_number = $this->generateReference(tenantId: $contract->tenant_id);

            return $this->invoiceRepository->createOne(dto: $dto);
        });
    }

    private function generateReference(int $tenantId): string
    {
        $now = now();

        $count = $this->invoiceRepository->countForUpdate();

        $tenantPart = str_pad((string) $tenantId, self::REFERENCE_TENANT_ID_PADDING, '0', STR_PAD_LEFT);
        $yearMonthPart = $now->format('Ym');
        $sequencePart = str_pad((string) ($count++), self::REFERENCE_SEQUENCE_PADDING, '0', STR_PAD_LEFT);

        return self::REFERENCE_PREFIX."-{$tenantPart}-{$yearMonthPart}-{$sequencePart}";
    }
}
