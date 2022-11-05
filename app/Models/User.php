<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property      int $id
 * @property      int $role_id
 * @property      string $first_name
 * @property      string $last_name
 * @property      string $email
 * @property      string $password
 * @property      \Illuminate\Support\Carbon|null $created_at
 * @property      \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method        static \Database\Factories\UserFactory factory(...$parameters)
 * @method        static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method        static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method        static \Illuminate\Database\Eloquent\Builder|User query()
 * @method        static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 * @method        static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin         \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    /**
     * Hash password when create user
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::set(fn ($value) => Hash::make($value));
    }

    /**
     * Get the role that owns the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Return permission names
     *
     * @return object
     */
    public function permissions()
    {
        return $this->role->permissions->pluck('name');
    }

    /**
     * If the user's role has the permission, return true
     *
     * @param string $access The name of the permission you want to check for.
     *
     * @return bool
     */
    public function hasAccess($access)
    {
        return $this->permissions()->contains($access);
    }
}
