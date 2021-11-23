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
            // 'path' => $this->getPathAttribute(),
            'replies' => ReplyResource::collection($this->replies),
        ];
    }
}
