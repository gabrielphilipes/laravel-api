<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = 'Unauthorized.';

    public function render()
    {
        return response()->json([
            'error'   => class_basename($this),
            'message' => $this->getMessage(),
        ], $this->code);
    }
}
