<?php

namespace App\Models;

use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use Cacheable, SoftDeletes;

    protected $connection = 'mysql_secondary';
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'level_id',
        'period_id',
    ];

    public function day()
    {
        return $this->hasOne(CourseDay::class, 'course_id', 'id');
    }
}
