<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    protected $code = 403;

    protected $message = 'Unauthorized! You are not allowed to perform this action.';

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error'   => class_basename($this),
            'message' => $this->getMessage(),
        ], $this->code);
    }
}
