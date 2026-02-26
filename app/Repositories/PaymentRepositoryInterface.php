<?php

namespace App\Repositories;

use App\Data\CreatePaymentDTO;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

interface PaymentRepositoryInterface
{
    public function all(): Collection;

    public function findById(int $id): ?Payment;

    public function createOne(CreatePaymentDTO $dto): Payment;

    public function update(Payment $payment, array $data): Payment;

    public function delete(Payment $payment): bool;
}
