<?php

namespace App\Data;

use App\Models\Contract;
use Illuminate\Foundation\Http\FormRequest;

class CreateInvoiceDTO extends BaseDTO
{
    public function __construct(
        public readonly float $subtotal,
        public readonly string $status,
        public readonly string $due_date,
        public ?int $contract_id = null,
        public ?string $invoice_number = null,
        public ?float $total = null,
        public ?float $tax_amount = null,
    ) {}

    public static function fromRequestWithContract(FormRequest $request, Contract $contract): static
    {
        $dto = parent::fromRequest(request: $request);
        $dto->contract_id = $contract->id;

        return $dto;
    }
}
