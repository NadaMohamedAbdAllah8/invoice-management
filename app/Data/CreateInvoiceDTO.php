<?php

namespace App\Data;

class CreateInvoiceDTO extends BaseDTO
{
    public function __construct(
        public readonly int $contract_id,
        public readonly float $subtotal,
        public readonly string $status,
        public readonly string $due_date,
        public ?string $invoice_number = null,
        public ?float $total = null,
        public ?float $tax_amount = null,
        public readonly ?string $paid_at = null,
    ) {}
}
