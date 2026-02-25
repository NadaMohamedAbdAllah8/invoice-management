<?php

namespace App\Http\Requests;

use App\Enums\InvoiceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subtotal' => ['required', 'decimal:0,2', 'min:0'],
            'status' => ['required', Rule::enum(InvoiceStatus::class)],
            'due_date' => ['required', 'date'],
            'paid_at' => ['nullable', 'date'],
        ];
    }
}
