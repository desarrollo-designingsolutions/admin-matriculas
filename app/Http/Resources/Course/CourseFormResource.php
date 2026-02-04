<?php

namespace App\Http\Resources\Course;

use App\Models\Day;
use App\Models\Book;
use App\Models\Level;
use App\Models\Period;
use App\Models\Discount;
use App\Models\CourseDay;
use App\Models\CourseBook;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseFormResource extends JsonResource
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
        $courseBook = CourseBook::where('course_id', $this->id)->first();
        $book = Book::find($courseBook?->book_id);
        $courseDay = CourseDay::where('course_id', $this->id)->first();
        $day = Day::find($courseDay?->day_id);
        $discount = Discount::where('day_course_id', $courseDay?->id)->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'time' => $courseDay?->time,
            'modalidad' => $courseDay?->modalidad,
            'course_init' => $courseDay?->course_init,
            'price' => $courseDay?->price,
            'orden' => $courseDay?->orden,
            'status' => $courseDay?->status,
            'start_date' => $discount?->start_date,
            'finish_date' => $discount?->finish_date,
            'discount' => $discount?->discount,
            'link' => $discount?->link,
            'link_book' => $discount?->link_book,
            'level_id' => [
                'value' => $this->level_id,
                'title' => $level?->level,
            ],
            'period_id' => [
                'value' => $this->period_id,
                'title' => $period?->period,
            ],
            'book_id' => [
                'value' => $book?->id,
                'title' => $book?->name,
            ],
            'day_id' => [
                'value' => $day?->id,
                'title' => $day?->day,
            ],
        ];
    }
}

