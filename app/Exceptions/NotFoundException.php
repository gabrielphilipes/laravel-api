<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $code = 404;

    protected $message = 'Page not found. If error persists, contact support.';

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error'   => class_basename($this),
            'message' => $this->getMessage(),
        ], $this->code);
    }
}
