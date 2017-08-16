<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    private $admin_actions = [
        ['name' => 'user-manage', 'label' => 'Manage users'],
        ['name' => 'article-update-any', 'label' => 'Edit others article'],
        ['name' => 'article-delete-any', 'label' => 'Delete others article'],
        ['name' => 'comment-update-any', 'label' => 'Edit others comment'],
        ['name' => 'comment-delete-any', 'label' => 'Delete others comment'],
    ];

    private $author_actions = [
        ['name' => 'article-create', 'label' => 'Create article'],
        ['name' => 'article-update', 'label' => 'Edit own article'],
        ['name' => 'article-delete', 'label' => 'Delete own article'],
        ['name' => 'comment-update', 'label' => 'Edit own comment'],
        ['name' => 'comment-delete', 'label' => 'Delete own comment'],
        ['name' => 'comment-update-article', 'label' => 'Update any comment of his/hers article'],
        ['name' => 'comment-delete-article', 'label' => 'Delete any comment of his/hers article']
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
