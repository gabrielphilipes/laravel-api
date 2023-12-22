<?php

namespace App\Scramble;

use Dedoc\Scramble\Extensions\ExceptionToResponseExtension;
use Dedoc\Scramble\Support\Generator\{Reference, Response, Schema, Types as OpenApiTypes};
use Dedoc\Scramble\Support\Type\{ObjectType, Type};
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ValidationExceptionExtension extends ExceptionToResponseExtension
{
    public function shouldHandle(Type $type): bool
    {
        return $type instanceof ObjectType &&
            $type->isInstanceOf(ValidationException::class);
    }

    public function toResponse(Type $type): ?Response
    {
        $validationResponseBodyType = (new OpenApiTypes\ObjectType())
            ->addProperty(
                'error',
                (new OpenApiTypes\StringType())
                    ->setDescription('Exception unique code.')
                    ->example('ValidationException')
            )
            ->addProperty(
                'message',
                (new OpenApiTypes\StringType())
                    ->setDescription('Message to developer.')
                    ->example('The title field is required. (and 1 more error)')
            )
            ->addProperty(
                'errors',
                (new OpenApiTypes\StringType())
                    ->setDescription('Details to validate errors.')
                    ->example([
                        'title'   => 'The title field is required.',
                        'content' => 'The content field is required.',
                    ])
            )
            ->setRequired(['message', 'error', 'errors']);

        return Response::make(422)
            ->description('This is the only exception that deviates from the standard. It adds the `errors` attribute, which contains details of the error found during data validation.')
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
