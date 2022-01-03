<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionCollection extends JsonResource
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
            'title' => $this->title,
            'body' => $this->body,
            'slug' => $this->slug,
            'category' => $this->category->name,
            'properties' => [
                'vote_count' => $this->votes->count() ?? 0,
                'up_votes' => $this->votes->where('vote', 'up')->count(),
                'down_votes' => $this->votes->where('vote', 'down')->count(),
                'views' => $this->views->count() ?? 0,
            ],
            'user_vote' => $this->votes->where('user_id', auth()->id())->first() ? $this->votes->where('user_id', auth()->id())->first()->vote : null,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
