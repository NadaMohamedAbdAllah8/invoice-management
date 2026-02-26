<?php

namespace App\Data\Invoice;

class CreateInvoiceDTO extends InvoiceDTO
{
    public function __construct(
        public readonly float $subtotal,
        public readonly string $status,
        public readonly string $due_date,
        public ?int $contract_id = null,
        public ?string $invoice_number = null,
        public ?float $total = null,
        public ?float $tax_amount = null,
    ) {
        parent::__construct(contract_id: $this->contract_id);
    }
}
