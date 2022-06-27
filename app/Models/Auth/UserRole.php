<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class UserRole extends Model
{
    use HasFactory;

    protected $collection = 'user_roles';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function getName():string
    {
        return $this->name;
    }

    public function getSlug():string
    {
        return $this->slug;
    }

    public function setName(string $name):void
    {
        $this->name = $name;
        $this->save();
    }

    public function setSlug(string $slug):void
    {
        $this->name = $slug;
        $this->save();
    }

    public function checkBySlug(string $slug): bool
    {
        return UserRole::where('slug', $slug)->exists();
    }

    public function getIdBySlug(string $slug): string
    {
        return UserRole::where('slug', $slug)->pluck('_id')[0];
    }
}
