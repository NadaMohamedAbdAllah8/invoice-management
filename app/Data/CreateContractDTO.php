<?php

namespace App\Data;

class CreateContractDTO extends BaseDTO
{
    public function __construct(
        public readonly string $unit_name,
        public readonly string $customer_name,
        public readonly string $rent_amount,
        public readonly string $start_date,
        public readonly string $end_date,
        public readonly string $status,
        public readonly bool $is_active = true,
    ) {}
}
