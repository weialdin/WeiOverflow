<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'votes_count' => $this->votes_count,
            'answers_count' => $this->answers_count,
            'views_count' => $this->views_count,
            'has_accepted_answer' => !is_null($this->best_answer_id),
            'summary' => str($this->body)->limit(150),
            'user' => UserResource::make($this->user),
            'created_at' => DateTimeResource::make($this->created_at),
            'updated_at' => DateTimeResource::make($this->updated_at),
            'can_be' => [
                'updated' => $request->user() && $request->user()->can('update', $this->resource),
                'deleted' => $request->user() && $request->user()->can('delete', $this->resource),
            ]
        ];
    }
}
