<?php

namespace App\Http\Resources\Examples;

use AllowDynamicProperties;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

#[AllowDynamicProperties]
class PostResource extends JsonResource
{
    /**
     * Converts the object to an array representation.
     *
     * @param Request $request The request object to be used in the conversion.
     *
     * @return array The array representation of the object.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => (int)$this->id,
            'title' => $this->title,
            /**
             * @var string|null Camel case title representation
             */
            'slug'    => $this->slug ?? null,
            'content' => $this->content,
        ];
    }
}
