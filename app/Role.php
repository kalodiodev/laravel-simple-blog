<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * Role belongs to many users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * A role belongs to many permissions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Give permission to Role
     *
     * @param Permission $permission
     * @return Model
     */
    public function givePermissionTo(Permission $permission)
    {
        return $this->permissions()->save($permission);
    }

    /**
     * Mass assign permissions to role
     * 
     * @param array $permissions
     */
    public function givePermissionsTo(array $permissions)
    {
        foreach ($permissions as $permission)
        {
            $this->givePermissionTo(Permission::whereName($permission)->firstOrFail());
        }
    }

    /**
     * Assign this role to user
     * 
     * @param User $user
     * @return Model
     */
    public function assignRoleTo(User $user)
    {
        return $this->users()->save($user);
    }
}
