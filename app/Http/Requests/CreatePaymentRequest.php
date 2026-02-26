<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'decimal:0,2', 'min:0'],
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'reference_number' => ['required', 'string', 'max:255'],
            'paid_at' => ['nullable', 'date'],
        ];
    }
}
