<?php

namespace App\Models;

use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use Cacheable, SoftDeletes;

    protected $connection = 'mysql_secondary';
    protected $table = 'levels';

    protected $fillable = [
        'level',
    ];
}
