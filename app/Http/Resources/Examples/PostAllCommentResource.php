<?php

namespace App\Http\Resources\Examples;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostAllCommentResource extends JsonResource
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
            /** @var string Comment complete, no limit of characters. */
            'comment' => $this->comment, 255,
        ];
    }
}
