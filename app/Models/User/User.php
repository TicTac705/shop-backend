<?php

namespace App\Models\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role_id
 *
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
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
        string $password,
        string $roleId
    ): self
    {
        $user = new self();

        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoleId($roleId);

        return $user;
    }

    public function getId(): string
    {
        return $this->id;
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

    public function getRoleId(string $roleId): string
    {
        return $this->role_id;
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

    public function setRoleId(string $roleId): self
    {
        $this->role_id = $roleId;
        return $this;
    }

    public function hasRole(string $slug):bool
    {
        $roleSlug = UserRole::getSlugById($this->role_id);

        return $slug === $roleSlug;
    }
}
