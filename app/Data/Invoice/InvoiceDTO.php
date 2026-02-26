<?php

namespace App\Data\Invoice;

use App\Data\BaseDTO;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceDTO extends BaseDTO
{
    public function __construct(public ?int $contract_id = null) {}

    public static function fromRequest(FormRequest $request): static
    {
        $dto = parent::fromRequest(request: $request);
        $dto->contract_id = $request->route('contract')->id;

        return $dto;
    }
}
