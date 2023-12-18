<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class AuthenticatedException extends Exception
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = 'You are not authenticated.';

    public function render(): JsonResponse
    {
        return response()->json([
            'error'   => class_basename($this),
            'message' => $this->getMessage(),
        ], $this->code);
    }
}
