<?php

namespace App\Providers;

use App\Article;
use App\Policies\ArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        Article::class => ArticlePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('create', 'App\Policies\ArticlePolicy@create');

//        if (Schema::hasTable('permissions')) {
//            foreach ($this->getPermissions() as $permission) {
//                $gate->define($permission->name, function ($user) use ($permission) {
//                    return $user->hasPermission($permission);
//                });
//            }
//        }
    }

    protected function getPermissions()
    {
//        return Permission::with('roles')->get();
    }
}
