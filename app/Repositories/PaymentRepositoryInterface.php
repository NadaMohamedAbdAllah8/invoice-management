<?php

namespace App\Repositories;

use App\Data\CreatePaymentDTO;
use App\Models\Payment;

interface PaymentRepositoryInterface
{
    public function createOne(CreatePaymentDTO $dto): Payment;
}
