<?php

namespace App\Http\Controllers\Admin;

use App\Data\Auth\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Services\AdminAuthService;
use App\Traits\RespondsWithJson;
use Illuminate\Http\JsonResponse;

class AdminAuthController extends Controller
{
    use RespondsWithJson;

    public function __construct(private AdminAuthService $authService) {}

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
