<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $collection = 'user_roles';

    protected $fillable = [
        'name',
        'slug'
    ];
}
