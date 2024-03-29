<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @method   static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method   static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method   static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method   static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method   static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @mixin    \Eloquent
 */
class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
    ];

    /**
     * The roles that belong to the permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
