<?php

namespace App\Policies;

use App\User;
use App\Image;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * Index all images policy
     *
     * @param User $user
     * @return bool
     */
    public function index(User $user)
    {
        return $user->hasPermission('image-index-all');
    }

    /**
     * Index images of user policy
     *
     * @param User $user
     * @return bool
     */
    public function index_own(User $user)
    {
        return $user->hasPermission('image-index-own');
    }

    /**
     * Delete image policy
     *
     * @param User $user
     * @param Image $image
     * @return bool
     */
    public function delete(User $user, Image $image)
    {
        if($user->hasPermission('image-delete-any'))
        {
            return true;
        }

        return ($user->owns($image) && $user->hasPermission('image-delete-own'));
    }
}