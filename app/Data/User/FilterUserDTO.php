<?php

namespace App\Data\User;

use App\Data\BaseDTO;

class FilterUserDTO extends BaseDTO
{
    public function __construct(
        public readonly ?string $email = null,
    ) {}
}
