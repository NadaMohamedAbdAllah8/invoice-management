<?php

namespace App\Repositories;

use App\Data\CreatePaymentDTO;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function all(): Collection
    {
        return Payment::query()->get();
    }

    public function findById(int $id): ?Payment
    {
        return Payment::query()->find($id);
    }

    public function createOne(CreatePaymentDTO $dto): Payment
    {
        return Payment::create($dto->toArray());
    }

    public function update(Payment $payment, array $data): Payment
    {
        $payment->update($data);

        return $payment->refresh();
    }

    public function delete(Payment $payment): bool
    {
        return (bool) $payment->delete();
    }
}
