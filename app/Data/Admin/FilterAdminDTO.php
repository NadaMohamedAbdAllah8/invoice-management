<?php

namespace App\Data\Admin;

use App\Data\BaseDTO;

class FilterAdminDTO extends BaseDTO
{
    public function __construct(
        public readonly ?string $email = null,
    ) {}
}
