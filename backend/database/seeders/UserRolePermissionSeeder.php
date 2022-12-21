<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // Permissions
            ['group' => 'Permissions', 'name' => 'create-permissions', 'display_name' => 'Create Permissions', 'guard_name' => 'api'],
            ['group' => 'Permissions', 'name' => 'edit-permissions', 'display_name' => 'Edit Permissions', 'guard_name' => 'api'],
            ['group' => 'Permissions', 'name' => 'list-permissions', 'display_name' => 'List Permissions', 'guard_name' => 'api'],
            ['group' => 'Permissions', 'name' => 'delete-permissions', 'display_name' => 'Delete Permissions', 'guard_name' => 'api'],
            // Roles
            ['group' => 'Roles', 'name' => 'create-roles', 'display_name' => 'Create', 'guard_name' => 'api'],
            ['group' => 'Roles', 'name' => 'edit-roles', 'display_name' => 'Edit', 'guard_name' => 'api'],
            ['group' => 'Roles', 'name' => 'list-roles', 'display_name' => 'List', 'guard_name' => 'api'],
            ['group' => 'Roles', 'name' => 'delete-roles', 'display_name' => 'Delete', 'guard_name' => 'api'],
            // Users
            ['group' => 'Users', 'name' => 'create-users', 'display_name' => 'Create User', 'guard_name' => 'api'],
            ['group' => 'Users', 'name' => 'list-users', 'display_name' => 'List Users', 'guard_name' => 'api'],
            ['group' => 'Users', 'name' => 'edit-users', 'display_name' => 'Edit Users', 'guard_name' => 'api'],
            ['group' => 'Users', 'name' => 'delete-users', 'display_name' => 'Delete Users', 'guard_name' => 'api'],
        ];

        DB::table('model_has_permissions')->delete();
        DB::table('model_has_roles')->delete();
        DB::table('role_has_permissions')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();
        DB::table('users')->delete();

        // default admin users
        $rootUser = User::create([
            'name' => 'Root',
            'email' => 'root@wakeb.com',
            'username' => 'root',
            'password' => Hash::make('12345678'),
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);
        $adminUser = User::create([
            'name' => 'Administrator',
            'primary_id' => $rootUser->id,
            'email' => 'admin@wakeb.com',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);

        // default roles
        $rootRole = Role::create([
            'name' => "$rootUser->id.Root",
            'display_name' => 'Root',
            'guard_name' => 'api',
        ]);
        $adminRole = Role::create([
            'name' => "$rootUser->id.Admin",
            'display_name' => 'Admin',
            'guard_name' => 'api',
        ]);
        $agentRole = Role::create([
            'name' => "$rootUser->id.Agent",
            'display_name' => 'Agent',
            'guard_name' => 'api',
        ]);

        $rootUser->assignRole($rootRole);
        $adminUser->assignRole($adminRole);

        // add default permissions
        Permission::insert($permissions);

        $rootRole->syncPermissions(Permission::all());
        $adminRole->syncPermissions(Permission::whereNotIn('group', [
            'Permissions', 'Features', 'Plugins',
        ])->get());
        $agentRole->syncPermissions(Permission::whereNotIn('group', [
            'Permissions', 'Agents', 'Packages', 'Features', 'Plugins', 'Languages', 'Settings',
        ])->get());

        // subscribe an agent
        $agentAdminUser = User::create([
            'name' => 'Cut',
            'email' => 'admin@cut.com',
            'username' => 'cut',
            'password' => Hash::make('12345678'),
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);
        $agentEmpUser = User::create([
            'name' => 'Cut',
            'primary_id' => $agentAdminUser->id,
            'email' => 'emp@cut.com',
            'username' => 'emp',
            'password' => Hash::make('12345678'),
            'email_verified_at' => \Carbon\Carbon::now(),
        ]);
        // default roles
        $agentAdminRole = Role::create([
            'name' => "$agentAdminUser->id.Admin",
            'display_name' => 'Admin',
            'guard_name' => 'api',
        ]);
        $agentEmpRole = Role::create([
            'name' => "$agentAdminUser->id.Admin.Emp",
            'display_name' => 'Emp',
            'guard_name' => 'api',
        ]);

        $agentAdminUser->assignRole($agentAdminRole);
        $agentEmpUser->assignRole($agentEmpRole);

        $agentAdminRole->syncPermissions(Permission::whereNotIn('group', ['Permissions'])->get());
        $agentEmpRole->syncPermissions(Permission::whereNotIn('group', ['Permissions', 'Roles', 'Users'])->get());
    }
}