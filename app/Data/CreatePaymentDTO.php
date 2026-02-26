<?php

namespace App\Data;

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

    public static function fromRequest(FormRequest $request): static
    {
        $dto = parent::fromRequest(request: $request);
        $dto->invoice_id = $request->route('invoice');

        return $dto;
    }
}
