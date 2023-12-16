<?php

namespace App\Exceptions\Examples;

use Exception;

class PostSlugInUsedException extends Exception
{
    protected $message = 'Slug is already in use.';

    public function render(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'error'   => class_basename($this),
            'message' => $this->getMessage(),
        ], 400);
    }
}
