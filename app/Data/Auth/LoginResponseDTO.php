<?php

namespace App\Data\Auth;

use App\Models\User;

class LoginResponseDTO
{
    public function __construct(
        public readonly string $token,
        public readonly string $token_type,
        public readonly User $user,
    ) {}
}
