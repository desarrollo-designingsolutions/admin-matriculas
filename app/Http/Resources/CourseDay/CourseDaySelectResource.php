<?php

namespace App\Http\Resources\CourseDay;

use App\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDaySelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $day = Day::find($this->day_id);

        return [
            'value' => $this->id,
            'title' => $day?->day,
        ];
    }
}
