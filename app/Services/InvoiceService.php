<?php

namespace App\Services;

use App\Data\CreatePaymentDTO;
use App\Data\Invoice\CreateInvoiceDTO;
use App\Data\Invoice\FilterInvoiceDto;
use App\Data\UpdateInvoiceDTO;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\Payment;
use App\Repositories\ContractRepositoryInterface;
use App\Repositories\InvoiceRepositoryInterface;
use App\Repositories\PaymentRepositoryInterface;
use App\Validators\InvoiceValidator;
use App\Validators\PaymentValidator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    const REFERENCE_PREFIX = 'INV';

    const REFERENCE_TENANT_ID_PADDING = 3;

    const REFERENCE_SEQUENCE_PADDING = 4;

    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository,
        private PaymentRepositoryInterface $paymentRepository,
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

            $dto->invoice_number = $this->generateInvoiceNumber(tenantId: $contract->tenant_id);

            return $this->invoiceRepository->createOne(dto: $dto);
        });
    }

    public function recordPayment(CreatePaymentDTO $dto): Payment
    {
        return DB::transaction(function () use ($dto): Payment {
            $invoice = $this->invoiceRepository->getOneById(id: $dto->invoice_id);
            PaymentValidator::throwExceptionIfInvoiceIsCancelled(invoice: $invoice);
            PaymentValidator::throwExceptionIfAmountExceedsRemainingBalance(
                invoice: $invoice,
                amount: $dto->amount,
            );

            $payment = $this->paymentRepository->createOne(dto: $dto);

            $totalPaid = $invoice->payments()->sum('amount');
            $invoiceTotal = $invoice->total;

            if ($totalPaid >= $invoiceTotal) {
                $updateInvoiceDto = new UpdateInvoiceDTO(
                    status: InvoiceStatus::PAID->value,
                    paid_at: now()->toDateTimeString(),
                );
            } else {
                $updateInvoiceDto = new UpdateInvoiceDTO(
                    status: InvoiceStatus::PARTIALLY_PAID->value,
                );
            }

            $this->updateOne(invoice: $invoice, dto: $updateInvoiceDto);

            return $payment;
        });
    }

    public function updateOne(Invoice $invoice, UpdateInvoiceDTO $dto): Invoice
    {
        return $this->invoiceRepository->updateOne(invoice: $invoice, dto: $dto);
    }

    public function findMany(FilterInvoiceDto $dto): LengthAwarePaginator
    {
        return $this->invoiceRepository->findMany(filters: $dto);
    }

    private function generateInvoiceNumber(int $tenantId): string
    {
        $count = $this->invoiceRepository->countForUpdate();

        $tenantPart = str_pad(
            (string) $tenantId,
            self::REFERENCE_TENANT_ID_PADDING,
            '0',
            STR_PAD_LEFT
        );
        $yearMonthPart = now()->format('Ym');
        $sequencePart = str_pad(
            (string) ($count++),
            self::REFERENCE_SEQUENCE_PADDING,
            '0',
            STR_PAD_LEFT
        );

        return self::REFERENCE_PREFIX."-{$tenantPart}-{$yearMonthPart}-{$sequencePart}";
    }
}
