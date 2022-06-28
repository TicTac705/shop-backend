<?php

namespace App\Models\Auth;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 *
 */
class UserRole extends Model
{
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
        return UserRole::where('slug', $slug)->first()->id;
    }
}
