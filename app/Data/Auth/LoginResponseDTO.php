<?php

namespace App\Data\Auth;

use App\Data\BaseDTO;
use App\Models\User;

class LoginResponseDTO extends BaseDTO
{
    public function __construct(
        public readonly string $token,
        public readonly string $token_type,
        public readonly User $user,
    ) {}
}
