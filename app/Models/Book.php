<?php

namespace App\Models;

use App\Traits\Cacheable;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Cacheable;

    protected $connection = 'mysql_secondary';
    protected $table = 'books';

    protected $fillable = [
        'name',
        'price',
        'status',
    ];
}
