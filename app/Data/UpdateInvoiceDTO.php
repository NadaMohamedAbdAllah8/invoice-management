<?php

namespace App\Data;

class UpdateInvoiceDTO extends BaseDTO
{
    public function __construct(
        public readonly string $status,
        public readonly ?string $paid_at = null,
    ) {}
}
