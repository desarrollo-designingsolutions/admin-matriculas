<?php

namespace App\Http\Resources\Discount;

use App\Models\Day;
use App\Models\CourseDay;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $courseDay = CourseDay::find($this->day_course_id);
        $day = Day::find($courseDay?->day_id);

        return [
            'id' => $this->id,
            'day_course_name' => $day?->day,
            'start_date' => $this->start_date,
            'finish_date' => $this->finish_date,
            'discount' => $this->discount,
            'payback' => $this->payback,
            'link' => $this->link,
            'link_book' => $this->link_book,
        ];
    }
}