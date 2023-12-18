<?php

namespace App\Scramble;

use App\Exceptions\{AuthenticatedException, UnauthorizedException};
use Dedoc\Scramble\Extensions\OperationExtension;
use Dedoc\Scramble\Support\Generator\{Operation, Response};
use Dedoc\Scramble\Support\RouteInfo;
use Dedoc\Scramble\Support\Type\{FunctionType, ObjectType};

/**
 * This extension is responsible for adding exceptions to the method return type
 * that may happen when an app navigates to the route.
 */
class ExceptionInferExtension extends OperationExtension
{
    public function handle(Operation $operation, RouteInfo $routeInfo)
    {
        if (!$methodType = $routeInfo->getMethodType()) {
            return;
        }

        $newResponses = collect($operation->responses)
            ->filter(fn ($response) => !str_contains(array_values($response->toArray())[0], 'AuthorizationException'));
        $newResponses         = $newResponses->toArray();
        $operation->responses = $newResponses;

        $this->attachAuthSanctumException($routeInfo, $methodType, $operation);
        $this->attachCanMiddlewareException($routeInfo, $methodType, $operation);
    }

    private function attachAuthSanctumException(RouteInfo $routeInfo, FunctionType $methodType, Operation $operation): void
    {
        if (in_array('auth:sanctum', $routeInfo->route->gatherMiddleware())) {
            $methodType->exceptions = [
                ...$methodType->exceptions,
                new ObjectType(AuthenticatedException::class),
            ];
            $operation->responses[] = $this->openApiTransformer->toResponse(new ObjectType(AuthenticatedException::class));
        }
    }

    private function attachCanMiddlewareException(RouteInfo $routeInfo, FunctionType $methodType, Operation $operation): void
    {
        if (collect($routeInfo->route->gatherMiddleware())->contains(fn ($m) => is_string($m) && str_starts_with($m, 'can:'))) {
            $methodType->exceptions = [
                ...$methodType->exceptions,
                new ObjectType(UnauthorizedException::class),
            ];
            $operation->responses[] = $this->openApiTransformer->toResponse(new ObjectType(UnauthorizedException::class));
        }
    }
}
