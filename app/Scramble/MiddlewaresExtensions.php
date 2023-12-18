<?php

namespace Dedoc\Scramble\Support\InferExtensions;

use Dedoc\Scramble\Extensions\OperationExtension;
use Dedoc\Scramble\Support\Generator\{Operation, Parameter};
use Dedoc\Scramble\Support\RouteInfo;
use Dedoc\Scramble\Support\Type\{FunctionType, ObjectType, TemplateType, Type};
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;

class MiddlewaresExtensions extends OperationExtension
{
    public function shouldHandle()
    {
        ds('shouldHandle');
    }

    public function handle(Operation $operation, RouteInfo $routeInfo)
    {
        if (!$methodType = $routeInfo->getMethodType()) {
            return;
        }

        $this->attachAuthSanctum($routeInfo, $methodType);
    }

    private function attachAuthSanctum(RouteInfo $routeInfo, FunctionType $methodType)
    {
        dd($routeInfo->route->gatherMiddleware());
        ds($routeInfo->route->gatherMiddleware());

        if (str_contains($routeInfo->route->uri(), 'api/examples/posts/{post}')) {
        }
    }

    private function attachAuthorizationException(RouteInfo $routeInfo, FunctionType $methodType)
    {

        if (!collect($routeInfo->route->gatherMiddleware())->contains(fn ($m) => is_string($m) && Str::startsWith($m, 'can:'))) {
            return;
        }

        if (collect($methodType->exceptions)->contains(fn (Type $e) => $e->isInstanceOf(AuthorizationException::class))) {
            return;
        }

        $methodType->exceptions = [
            ...$methodType->exceptions,
            new ObjectType(AuthorizationException::class),
        ];
    }
}
