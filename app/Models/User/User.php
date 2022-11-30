<?php

namespace App\Models\User;

use App\Dto\User\RoleLightForTokenDto;
use App\Exceptions\AppException;
use App\Helpers\Mappers\MongoMapper;
use App\Models\Catalog\Basket;
use App\Models\Catalog\Order;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User\UserBase as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string[] $role_ids
 * @property null|Carbon $email_verified_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasFactory;

    protected $collection  = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_ids'
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
        '_id' => 'uuid',
        'role_ids' => 'uuid-array',
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string[] $roleIds
     * @return static
     */
    public static function create(
        string $name,
        string $email,
        string $password,
        array $roleIds
    ): self
    {
        $user = new self();

        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles($roleIds);

        return $user;
    }

    public function getAuthIdentifierName(): string
    {
        return $this->getKeyName();
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'roles' => RoleLightForTokenDto::fromList(Auth::user()->roles()->all()),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->email_verified_at;
    }

    public function getEmailVerifiedAtTimestamp(): ?int
    {
        return $this->email_verified_at === null ? null : $this->email_verified_at->timestamp;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->convertKeys($this->role_ids);
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

    /**
     * @param string[] $roleIds
     * @return $this
     */
    public function setRoles(array $roleIds): self
    {
        $this->role_ids = $roleIds;
        return $this;
    }

    public function roles(): Collection
    {
        return Role::getByIds($this->getRoles());
    }

    public function hasRoles(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if ($this->hasRole($slug)) {
                return true;
            }
        }

        return false;
    }

    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->isNotEmpty();
    }

    /**
     * @throws AppException
     */
    public function baskets()
    {
        return Basket::query()->where('user_id', '=', MongoMapper::toMongoUuid($this->getId()))->get();
    }

    /**
     * @throws AppException
     */
    public function orders()
    {
        return Order::query()->where('user_id', '=', MongoMapper::toMongoUuid($this->getId()))->get();
    }

    public function getCreatedAtTimestamp(): ?int
    {
        return $this->created_at === null ? null : $this->created_at->timestamp;
    }

    public function getUpdatedAtTimestamp(): ?int
    {
        return $this->updated_at === null ? null : $this->updated_at->timestamp;
    }

    public function getById(string $id)
    {
        return self::where('_id', '=', $id)->firstOrFail();
    }
}
