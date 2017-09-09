<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    private $admin_actions = [
        // Users
        ['name' => 'user-view', 'label' => 'Users management, view user'],
        ['name' => 'user-create', 'label' => 'Users management, create user'],
        ['name' => 'user-update', 'label' => 'Users management, edit user'],
        ['name' => 'user-delete', 'label' => 'Users management, delete user'],
        // Articles
        ['name' => 'article-update-any', 'label' => 'Edit others article'],
        ['name' => 'article-delete-any', 'label' => 'Delete others article'],
        // Comments
        ['name' => 'comment-update-any', 'label' => 'Edit others comment'],
        ['name' => 'comment-delete-any', 'label' => 'Delete others comment'],
        // Tags
        ['name' => 'tag-view-index', 'label' => 'View tags index'],
        ['name' => 'tag-create', 'label' => 'Create tag'],
        ['name' => 'tag-update', 'label' => 'Update tag'],
        ['name' => 'tag-delete', 'label' => 'Delete tag'],
        // Profiles
        ['name' => 'profile-detailed-view', 'label' => 'View user\'s detailed profile'],
        // Images
        ['name' => 'image-index-all', 'label' => 'Index all images'],
        ['name' => 'image-delete-any', 'label' => 'Delete any image'],
        ['name' => 'image-view-any', 'label' => 'View any image'],
    ];

    private $author_actions = [
        // Articles
        ['name' => 'article-create', 'label' => 'Create article'],
        ['name' => 'article-update', 'label' => 'Edit own article'],
        ['name' => 'article-delete', 'label' => 'Delete own article'],
        // Comments
        ['name' => 'comment-update', 'label' => 'Edit own comment'],
        ['name' => 'comment-delete', 'label' => 'Delete own comment'],
        ['name' => 'comment-update-article', 'label' => 'Update any comment of his/hers article'],
        ['name' => 'comment-delete-article', 'label' => 'Delete any comment of his/hers article'],
        // Images
        ['name' => 'image-index-own', 'label' => 'Index own images'],
        ['name' => 'image-view-own', 'label' => 'View own image'],
        ['name' => 'image-delete-own', 'label' => 'Delete own image'],
    ];

    private $guest_actions = [
        ['name' => 'comment-create', 'label' => 'Create comment']
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permissions
        DB::table('permissions')->insert($this->admin_actions);
        DB::table('permissions')->insert($this->author_actions);
        DB::table('permissions')->insert($this->guest_actions);

        // Admin permissions
        $admin = Role::whereName('admin')->firstOrFail();
        $admin->givePermissionsTo($this->admin_actions);
        $admin->givePermissionsTo($this->author_actions);
        $admin->givePermissionsTo($this->guest_actions);

        // Author permissions
        $author = Role::whereName('author')->firstOrFail();
        $author->givePermissionsTo($this->author_actions);
        $author->givePermissionsTo($this->guest_actions);

        // Guest permissions
        $guest = Role::whereName('guest')->firstOrFail();
        $guest->givePermissionsTo($this->guest_actions);
    }

}
