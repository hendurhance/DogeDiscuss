<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'reply' => $this->body,
            'user' => $this->user->name,
            'properties' => [
                'like_count' => $this->likes->count(),
                'is_liked' => $this->likes->where('user_id', auth()->id())->count() > 0,
            ],
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
