<?php

namespace App\Http\Controllers;

use App\Data\Auth\LoginDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Services\AuthService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use RespondsWithJson;

    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $loginDto = LoginDTO::fromRequest($request);

        $data = $this->authService->login(credentials: $loginDto);

        return $this->returnItemWithSuccessMessage(
            item: new LoginResource($data),
            message: 'Logged in successfully'
        );
    }
}
