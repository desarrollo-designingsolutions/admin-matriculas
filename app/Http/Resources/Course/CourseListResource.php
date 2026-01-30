<?php

namespace App\Http\Resources\Course;

use App\Models\Level;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $level = Level::find($this->level_id);
        $period = Period::find($this->period_id);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'level_name' => $level?->level,
            'period_name' => $period?->period,
        ];
    }
}
