<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    private $roles = [
        ['name' => 'admin', 'label' => 'Administrator'],
        ['name' => 'author', 'label' => 'Articles author'],
        ['name' => 'guest', 'label' => 'Guest user']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert($this->roles);
    }
}
