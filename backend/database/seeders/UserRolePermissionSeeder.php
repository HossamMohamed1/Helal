<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\RolesService;
use Illuminate\Database\Seeder;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RolesService::CreateRole();

        $root = User::create([
            'name' => 'Root',
            'email' => 'root@wakeb.com',
            'password' => bcrypt(123456),
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@wakeb.com',
            'password' => bcrypt(123456),
        ]);

        $root->syncRoles(['root']);
        $admin->assignRole('admin');

    }
}