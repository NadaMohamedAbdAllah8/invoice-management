<?php

namespace App\Exceptions;

use App\Traits\RespondsWithJson;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ContractNotActiveException extends Exception
{
    use RespondsWithJson;

    public function render(): JsonResponse
    {
        return $this->returnErrorMessage('Contract is not active!', Response::HTTP_BAD_REQUEST);
    }
}
