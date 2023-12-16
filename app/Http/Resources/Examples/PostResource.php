<?php

namespace App\Http\Resources\Examples;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public static $wrap = 'post';

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
            'id'      => (int)$this->id,
            'title'   => $this->title,
            'slug'    => $this->slug,
            'content' => $this->content,
        ];
    }
}
