<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'body' => $this->body,
            'user' => UserResource::make($this->user),
            'question_id' => $this->question_id,
            'votes_count' => $this->votes_count,
            'created_at' => DateTimeResource::make($this->created_at),
            'can_be' => [
                'updated' => $request->user() && $request->user()->can('update', $this->resource),
                'deleted' => $request->user() && $request->user()->can('delete', $this->resource),
            ]
        ];
    }
}
