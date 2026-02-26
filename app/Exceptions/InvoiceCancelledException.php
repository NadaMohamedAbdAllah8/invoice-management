<?php

namespace App\Exceptions;

use App\Traits\RespondsWithJson;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InvoiceCancelledException extends Exception
{
    use RespondsWithJson;

    public function render(): JsonResponse
    {
        return $this->returnErrorMessage('Cancelled invoices cannot receive payments!', Response::HTTP_BAD_REQUEST);
    }
}
