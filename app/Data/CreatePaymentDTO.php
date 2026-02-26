<?php

namespace App\Data;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentDTO extends BaseDTO
{
    public function __construct(
        public readonly float $amount,
        public readonly string $payment_method,
        public readonly string $reference_number,
        public ?string $paid_at = null,
        public ?int $invoice_id = null,
    ) {
        $this->paid_at = $this->paid_at ?? Carbon::now()->toDateTimeString();
    }

    public static function fromRequestWithInvoice(FormRequest $request, Invoice $invoice): static
    {
        $dto = parent::fromRequest(request: $request);
        $dto->invoice_id = $invoice->id;

        return $dto;
    }
}
