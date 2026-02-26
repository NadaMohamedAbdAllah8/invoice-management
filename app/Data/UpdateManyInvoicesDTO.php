<?php

namespace App\Data;

class UpdateManyInvoicesDTO extends BaseDTO
{
    public function __construct(
        public readonly string $status,
    ) {}
}
