<?php

namespace App\Http\Resources\Examples;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
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
