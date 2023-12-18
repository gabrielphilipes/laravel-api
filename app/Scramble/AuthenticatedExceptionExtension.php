<?php

namespace App\Scramble;

use App\Exceptions\{AuthenticatedException, UnauthorizedException};
use Dedoc\Scramble\Extensions\ExceptionToResponseExtension;
use Dedoc\Scramble\Support\Generator\{Reference, Response, Schema, Types as OpenApiTypes};
use Dedoc\Scramble\Support\Type\{ObjectType, Type};
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Str;

class AuthenticatedExceptionExtension extends ExceptionToResponseExtension
{
    public function shouldHandle(Type $type): bool
    {
        return $type instanceof ObjectType
            && $type->isInstanceOf(AuthenticatedException::class);
    }

    public function toResponse(Type $type): ?Response
    {
        $e = new AuthenticatedException();

        if ($type->isInstanceOf(AuthorizationException::class)) {
            $e = new UnauthorizedException();
        }

        $validationResponseBodyType = (new OpenApiTypes\ObjectType())
            ->addProperty(
                'error',
                (new OpenApiTypes\StringType())
                    ->setDescription('Exception unique code.')
                    ->example(class_basename($e))
            )
            ->addProperty(
                'message',
                (new OpenApiTypes\StringType())
                    ->setDescription('Message to developer.')
                    ->example($e->getMessage())
            )
            ->setRequired(['message']);

        return Response::make($e->getCode())
            ->description($e->getMessage())
            ->setContent(
                'application/json',
                Schema::fromType($validationResponseBodyType)
            );
    }

    public function reference(ObjectType $type)
    {
        return new Reference('responses', Str::start($type->name, '\\'), $this->components);
    }
}
