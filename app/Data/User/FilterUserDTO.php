<?php

namespace App\Data\User;

class FilterUserDTO
{
    public function __construct(
        public readonly ?string $email = null,
    ) {}
}
