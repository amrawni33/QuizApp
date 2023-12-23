<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'quiz_time' => $this->quiz_time,
            'quiz_date' => $this->quiz_date,
            'Q&A' => QuizDetailsResource::collection($this->whenLoaded('details')),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
