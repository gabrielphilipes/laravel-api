<?php

namespace App\Exceptions\Examples;

use Exception;
use Illuminate\Support\Facades\Log;

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

    public function report(): void
    {
        /**
         * By default, the exception not is reported.
         * If you want to report the exception, uncomment the line below and customize the log.
         */
        // Log::error($this->getMessage(), [ 'exception' => class_basename($this) ]);
    }
}
