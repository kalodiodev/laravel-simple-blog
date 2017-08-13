<?php

namespace App\Policies;

use App\Article;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->hasPermission('article-create');
    }
    
    public function update(User $user, Article $article)
    {
        return (($user->hasPermission('article-update')) && ($user->ownsArticle($article)));
    }
    
    public function delete(User $user, Article $article)
    {
        return (($user->hasPermission('article-update')) && ($user->ownsArticle($article)));
    }
}
