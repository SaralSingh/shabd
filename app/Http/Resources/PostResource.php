<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at,

            // ✅ yaha likhna hai
            'picture_url' => $this->picture
                ? asset('storage/' . $this->picture)
                : null,

            'likes' => $this->likes,
            'dislikes' => $this->dislikes,

            'user' => [
                'name' => $this->user->name,
                'username' => $this->user->username,
            ],
        ];
    }
}
