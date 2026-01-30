<?php

namespace App\Http\Resources\CourseBook;

use App\Models\Course;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseBookListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $course = Course::find($this->course_id);
        $book = Book::find($this->book_id);

        return [
            'id' => $this->id,
            'course_name' => $course?->name,
            'book_name' => $book?->name,
        ];
    }
}
