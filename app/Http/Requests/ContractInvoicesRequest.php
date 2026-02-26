<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatus;
use Illuminate\Validation\Rule;

class ContractInvoicesRequest extends PaginateRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'status' => ['nullable', Rule::enum(InvoiceStatus::class)],
                'from_due_date' => ['nullable', 'date'],
                'to_due_date' => ['nullable', 'date', 'after_or_equal:from_due_date'],
            ]
        );
    }
}
