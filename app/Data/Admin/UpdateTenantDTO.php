<?php

namespace App\Data\Admin;

use App\Data\BaseDTO;

class UpdateTenantDTO extends BaseDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $domain = null,
    ) {}
}
