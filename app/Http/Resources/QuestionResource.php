<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ReplyResource;

class QuestionResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'category' => $this->category->name,
            'created_at' => $this->created_at->diffForHumans(),
            'user' => $this->user->name,
            'replies' => ReplyResource::collection($this->replies),
            'properties' => [
                'vote_count' => $this->votes->count() ?? 0,
                'up_votes' => $this->votes->where('vote', 'up')->count(),
                'down_votes' => $this->votes->where('vote', 'down')->count(),
                'views' => $this->views->count() ?? 0,
            ],
            'user_vote' => $this->votes->where('user_id', auth()->id())->first() ? $this->votes->where('user_id', auth()->id())->first()->vote : null,
            // 'path' => $this->getPathAttribute(),
        ];
    }
}
