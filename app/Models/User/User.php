<?php

namespace App\Models\User;

use App\Dto\User\RoleDtoCollection;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\UserBase as Authenticatable;
use App\PivotModels\User\UserRole;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property ?Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function create(
        string $name,
        string $email,
        string $password
    ): self
    {
        $user = new self();

        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);

        return $user;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [
            'roles' => (new RoleDtoCollection(Auth::user()->role->all()))->only(['slug'])->toArray(),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(string $email): string
    {
        return $this->email;
    }

    public function getPassword(string $password): string
    {
        return $this->password;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function role(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles')->using(UserRole::class);
    }

    public function hasRole(string $slug): bool
    {
        return $this->role()->where('slug', $slug)->exists();
    }
}
