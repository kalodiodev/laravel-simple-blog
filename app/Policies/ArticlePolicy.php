<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Create article policy
     * 
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermission('article-create');
    }

    /**
     * Update article policy
     * 
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function update(User $user, Article $article)
    {
        if($user->hasPermission('article-update-any'))
        {
            return true;
        }

        return (($user->hasPermission('article-update')) && ($user->ownsArticle($article)));
    }

    /**
     * Delete article policy
     * 
     * @param User $user
     * @param Article $article
     * @return bool
     */
    public function delete(User $user, Article $article)
    {
        if($user->hasPermission('article-delete-any'))
        {
            return true;
        }

        return (($user->hasPermission('article-update')) && ($user->ownsArticle($article)));
    }
}
