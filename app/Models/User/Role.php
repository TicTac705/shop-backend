<?php

namespace App\Models\User;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Role extends ModelBase
{
    use HasFactory;

    protected $collection  = 'roles';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string'
    ];

    public static function create(
        string $name,
        string $slug
    ): self
    {
        $userRole = new self();

        $userRole->setSlug($slug);
        $userRole->setName($name);

        return $userRole;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getSlug():string
    {
        return $this->slug;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSlug(string $slug):self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getIdBySlug(string $slug): string
    {
        return self::where('slug', $slug)->first()->id;
    }
}
