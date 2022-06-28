<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Image extends Model
{
    protected $collection = 'images';

    protected $fillable = [
        'user_id',
        'src'
    ];
}
