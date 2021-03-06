<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Index tags policy
     * 
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return ($user->hasPermission('tag-view-index') || 
            $user->hasPermission('tag-create') || 
            $user->hasPermission('tag-update') || 
            $user->hasPermission('tag-delete'));
    }

    /**
     * Create tag policy
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('tag-create');
    }

    /**
     * Update tag policy
     *
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasPermission('tag-update');
    }

    /**
     * Delete tag policy
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('tag-delete');
    }
}
