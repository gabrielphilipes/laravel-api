<?php

namespace App\Http\Resources\Examples;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->id,
            /** @var string ExampleComment length is limited to 255 characters. */
            'comment' => Str::limit($this->comment, 255),
        ];
    }
}
