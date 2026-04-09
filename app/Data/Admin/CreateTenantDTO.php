<?php

namespace App\Data\Admin;

use App\Data\BaseDTO;

class CreateTenantDTO extends BaseDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $domain,
    ) {}
}
