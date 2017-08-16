<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Create comment policy
     * 
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        // User has permission to create comment
        return $user->hasPermission('comment-create');
    }

    /**
     * Update comment policy
     * 
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        if($user->hasPermission('comment-update-any'))
        {
            // User has permission to update any comment
            return true;
        }

        if(($user->hasPermission('comment-update-article') && ($user->ownsArticle($comment->article))))
        {
            // User has permission to update any comment in article that is owner
            return true;
        }

        // User has permission to update his own comment
        return (($user->hasPermission('comment-update')) && ($user->ownsComment($comment)));
    }

    /**
     * Delete comment policy
     * 
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        if($user->hasPermission('comment-delete-any'))
        {
            // User has permission to delete any comment
            return true;
        }

        if(($user->hasPermission('comment-delete-article') && ($user->ownsArticle($comment->article))))
        {
            // User has permission to delete any comment in article that is owner
            return true;
        }

        // User has permission to delete his own comment
        return (($user->hasPermission('comment-delete')) && ($user->ownsComment($comment)));
    }
}
