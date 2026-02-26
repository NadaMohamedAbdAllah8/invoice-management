<?php

namespace App\Repositories;

use App\Data\CreatePaymentDTO;
use App\Models\Payment;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function createOne(CreatePaymentDTO $dto): Payment
    {
        return Payment::create($dto->toArray());
    }
}
