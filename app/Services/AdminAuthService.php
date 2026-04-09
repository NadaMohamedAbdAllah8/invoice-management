<?php

namespace App\Services;

use App\Constants\Auth;
use App\Data\Admin\FilterAdminDTO;
use App\Data\Auth\LoginDTO;
use App\Data\Auth\LoginResponseDTO;
use App\Exceptions\AuthenticationException;
use App\Repositories\Admin\AdminRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AdminAuthService
{
    public function __construct(private AdminRepositoryInterface $adminRepo) {}

    public function login(LoginDTO $credentials): LoginResponseDTO
    {
        $admin = $this->adminRepo->findOne(filters: new FilterAdminDTO(email: $credentials->email));

        if (! $admin || ! Hash::check($credentials->password, $admin->password)) {
            throw new AuthenticationException('The provided credentials are incorrect.');
        }

        $token = $admin->createToken('admin-api-token')->plainTextToken;

        return new LoginResponseDTO(
            token: $token,
            token_type: Auth::TOKEN_TYPE,
            user: $admin
        );
    }
}
