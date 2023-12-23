<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizDetailsResource extends JsonResource
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
            'question' => $this->question,
            'answer' => $this->answer,
            'wrong_answer1' => $this->wrong_answer1,
            'wrong_answer2' => $this->wrong_answer2,
            'wrong_answer3' => $this->wrong_answer3,
            'quiz' => new QuizResource($this->whenLoaded('quiz')),
        ];
    }
}
