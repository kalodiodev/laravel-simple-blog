<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    private $admin_actions = [
        ['name' => 'user-manage', 'label' => 'Manage users'],
        ['name' => 'article-update-any', 'label' => 'Edit others article'],
        ['name' => 'article-delete-any', 'label' => 'Delete others article']
    ];

    private $author_actions = [
        ['name' => 'article-create', 'label' => 'Create article'],
        ['name' => 'article-update', 'label' => 'Edit own article'],
        ['name' => 'article-delete', 'label' => 'Delete own article']
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

        // Admin permissions
        $admin = Role::whereName('admin')->firstOrFail();
        $admin->givePermissionsTo($this->admin_actions);
        $admin->givePermissionsTo($this->author_actions);

        // Author permissions
        $author = Role::whereName('author')->firstOrFail();
        $author->givePermissionsTo($this->author_actions);
    }

}
