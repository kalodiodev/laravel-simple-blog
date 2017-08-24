<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * View detailed profile policy
     * 
     * @param User $auth
     * @param User $user
     * @return bool
     */
    public function view(User $auth, User $user)
    {
        if(($auth->id === $user->id) || ($auth->hasPermission('profile-detailed-view')))
        {
            return true;
        }

        return false;
    }

    /**
     * Update profile policy
     * 
     * @param User $auth
     * @param User $user
     * @return bool
     */
    public function update(User $auth, User $user)
    {
        if($auth->id === $user->id)
        {
            return true;
        }
    }
}
