<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
            'question' => $this->question->title,
            'question_slug' => $this->question->slug,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
