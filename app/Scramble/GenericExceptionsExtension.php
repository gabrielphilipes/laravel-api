<?php

namespace App\Scramble;

use Dedoc\Scramble\Extensions\ExceptionToResponseExtension;
use Dedoc\Scramble\Support\Generator\{Reference, Response, Schema, Types as OpenApiTypes};
use Dedoc\Scramble\Support\Type\{ObjectType, Type};
use Illuminate\Support\Str;

class GenericExceptionsExtension extends ExceptionToResponseExtension
{
    private string $exceptionNamespace;

    public function shouldHandle(Type $type): bool
    {
        $this->exceptionNamespace = '\\' . $type->toString();

        return $type instanceof ObjectType
            && (
                class_exists($this->exceptionNamespace) &&
                $type->isInstanceOf(\Exception::class) &&
                Str::startsWith($this->exceptionNamespace, '\\App\\Exceptions\\')
            );
    }

    public function toResponse(Type $type): ?Response
    {
        /** @var \Exception $e */
        $e = new $this->exceptionNamespace();

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
