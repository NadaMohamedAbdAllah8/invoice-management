<?php

namespace App\Services;

use App\Constants\Auth;
use App\Data\Auth\LoginDTO;
use App\Data\Auth\LoginResponseDTO;
use App\Data\User\FilterUserDTO;
use App\Exceptions\AuthenticationException;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(private UserRepositoryInterface $userRepo) {}

    public function login(LoginDTO $credentials): LoginResponseDTO
    {
        $user = $this->userRepo->findOne(filters: new FilterUserDTO(email: $credentials->email));

        if (! $user || ! Hash::check($credentials->password, $user->password)) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        $token = $user->createToken('user-api-token')->plainTextToken;

        return new LoginResponseDTO(
            token: $token,
            token_type: Auth::TOKEN_TYPE,
            user: $user
        );
    }
}
