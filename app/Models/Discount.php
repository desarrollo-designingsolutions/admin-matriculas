<?php

namespace App\Models;

use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use Cacheable, SoftDeletes;

    protected $connection = 'mysql_secondary';
    protected $table = 'discounts';

    protected $fillable = [
        'start_date',
        'finish_date',
        'discount',
        'payback',
        'link',
        'link_book',
        'day_course_id',
    ];
}
