<?php

namespace App\Http\Resources\CourseDay;

use App\Models\Course;
use App\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDayListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $course = Course::find($this->course_id);
        $day = Day::find($this->day_id);

        return [
            'id' => $this->id,
            'course_name' => $course?->name,
            'day_name' => $day?->day,
            'time' => $this->time,
            'modalidad' => $this->modalidad,
            'course_init' => $this->course_init,
            'price' => $this->price,
            'status' => $this->status,
            'orden' => $this->orden,
            'periodo' => $this->periodo,
        ];
    }
}
