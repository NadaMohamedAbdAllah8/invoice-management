<?php

namespace App\Exceptions;

use App\Traits\RespondsWithJson;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthorizationException extends Exception
{
    use RespondsWithJson;

    public function render(): JsonResponse
    {
        return $this->returnErrorMessage(
            'You are not allowed to perform this action.',
            Response::HTTP_UNAUTHORIZED
        );
    }
}
