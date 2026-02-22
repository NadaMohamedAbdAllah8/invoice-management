<?php

namespace App\Data\Auth;

use App\Data\BaseDTO;

class LoginDTO extends BaseDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}
}
