<?php

namespace App\Exceptions;

use App\Traits\RespondsWithJson;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InsufficientBalanceException extends Exception
{
    use RespondsWithJson;

    public function render(): JsonResponse
    {
        return $this->returnErrorMessage('Payment amount exceeds invoice remaining balance!', Response::HTTP_BAD_REQUEST);
    }
}
