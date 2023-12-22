<?php

namespace App\Scramble;

use App\Exceptions\NotFoundException;
use Dedoc\Scramble\Extensions\ExceptionToResponseExtension;
use Dedoc\Scramble\Support\Generator\{Reference, Response, Schema, Types as OpenApiTypes};
use Dedoc\Scramble\Support\Type\{ObjectType, Type};
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundExceptionExtension extends ExceptionToResponseExtension
{
    public function shouldHandle(Type $type): bool
    {
        return $type instanceof ObjectType
            && (
                $type->isInstanceOf(RecordsNotFoundException::class) ||
                $type->isInstanceOf(NotFoundHttpException::class) ||
                $type->isInstanceOf(NotFoundException::class)
            );
    }

    public function toResponse(Type $type): ?Response
    {
        $e = new NotFoundException();

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
