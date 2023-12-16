<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        switch (true) {
            case $e instanceof ValidationException:
                return response()->json([
                    'error'   => class_basename($e),
                    'message' => $e->getMessage(),
                    'errors'  => array_map(
                        fn ($item) => implode('; ', $item),
                        $e->validator->errors()->messages()
                    ),
                ], 400);

            case $e instanceof ModelNotFoundException:
                throw new NotFoundException('Register not found. Please, check the data and try again.');

            case $e instanceof AuthenticationException:
                throw new UnauthorizedException();

            default:
                //                dd($e);
                return parent::render($request, $e);
        }
    }
}
