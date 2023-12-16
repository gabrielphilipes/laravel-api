<?php

namespace App\Exceptions\Examples;

use Exception;

class PostSlugInUsedException extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = 'Slug is already in use.';

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error'   => class_basename($this),
            'message' => $this->getMessage(),
        ], $this->code);
    }
}
