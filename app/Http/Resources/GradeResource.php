<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
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
            'grade' => $this->grade,
            'student_name' => $this->user?->name,
            'student_id' => $this->user?->id,
            'quiz_id' => $this->quiz?->id,
            'quiz_code' => $this->quiz?->code,
        ];
    }
}
