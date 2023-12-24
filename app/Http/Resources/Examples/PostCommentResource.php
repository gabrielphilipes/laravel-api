<?php

namespace App\Http\Resources\Examples;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id'      => (int)$this->id,
            'post_id' => (int)$this->post_id,
            'comment' => $this->comment,
        ];
    }
}
