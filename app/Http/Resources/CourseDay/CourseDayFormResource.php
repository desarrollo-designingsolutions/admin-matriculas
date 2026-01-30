<?php

namespace App\Http\Resources\CourseDay;

use App\Models\Day;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDayFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $day = Day::find($this->day_id);
        $period = Period::where('period', $this->periodo)->first();

        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'day_id' => [
                'value' => $this->day_id,
                'title' => $day?->day,
            ],
            'time' => $this->time,
            'modalidad' => $this->modalidad,
            'course_init' => $this->course_init,
            'price' => $this->price,
            'status' => $this->status,
            'orden' => $this->orden,
            'periodo' => [
                'value' => $period?->id ?? null,
                'title' => $this->periodo,
            ],
        ];
    }
}
