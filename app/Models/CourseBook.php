<?php

namespace App\Models;

use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;

class CourseBook extends Model
{
    use Cacheable;

    protected $connection = 'mysql_secondary';
    protected $table = 'course_has_books';

    protected $fillable = [
        'course_id',
        'book_id',
        'status',
    ];
}
