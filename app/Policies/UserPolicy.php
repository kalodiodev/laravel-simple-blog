<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * View detailed profile policy
     * 
     * @param User $auth
     * @param User $user
     * @return bool
     */
    public function view_profile(User $auth, User $user)
    {
        return (($auth->id === $user->id) || ($auth->hasPermission('profile-detailed-view')));
    }

    /**
     * Update profile policy
     * 
     * @param User $auth
     * @param User $user
     * @return bool
     */
    public function update_profile(User $auth, User $user)
    {
        return (($auth->id === $user->id) || ($this->update($auth)));
    }

    /**
     * View users policy
     *
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return ($user->hasPermission('user-view') || 
            ($this->create($user)) ||
            ($this->update($user)) ||
            ($this->delete($user)));
    }

    /**
     * Create users policy
     * 
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('user-create');
    }

    /**
     * User update policy
     * 
     * @param User $user
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasPermission('user-update');
    }

    /**
     * User delete policy
     * 
     * @param User $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasPermission('user-delete');
    }
}
