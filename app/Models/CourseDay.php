<?php

namespace App\Models;

use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseDay extends Model
{
    use Cacheable, SoftDeletes;

    protected $connection = 'mysql_secondary';
    protected $table = 'day_courses';

    protected $fillable = [
        'time',
        'modalidad',
        'course_init',
        'price',
        'status',
        'orden',
        'periodo',
        'course_id',
        'day_id',
    ];
}