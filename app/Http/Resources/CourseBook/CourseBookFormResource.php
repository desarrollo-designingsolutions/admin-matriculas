<?php

namespace App\Http\Resources\CourseBook;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseBookFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $book = Book::find($this->book_id);

        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'book_id' => [
                'value' => $this->book_id,
                'title' => $book?->name,
            ],
        ];
    }
}
