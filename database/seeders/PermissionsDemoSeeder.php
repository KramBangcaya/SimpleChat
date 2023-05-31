<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan migrate:fresh --seed --seeder=PermissionsDemoSeeder
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        // Role::create(['guard_name' => 'admin', 'name' => 'manager']);
        // $permission = Permission::create(['guard_name' => 'admin', 'name' => 'publish articles']);

        Permission::create(['guard_name' => 'api','name' => 'edit user']);
        Permission::create(['guard_name' => 'api','name' => 'delete user']);
        Permission::create(['guard_name' => 'api','name' => 'create user']);
        Permission::create(['guard_name' => 'api','name' => 'access user']);
        Permission::create(['guard_name' => 'api','name' => 'list user']);
        Permission::create(['guard_name' => 'api','name' => 'show user']);

        Permission::create(['guard_name' => 'api','name' => 'edit permission']);
        Permission::create(['guard_name' => 'api','name' => 'delete permission']);
        Permission::create(['guard_name' => 'api','name' => 'create permission']);
        Permission::create(['guard_name' => 'api','name' => 'access permission']);
        Permission::create(['guard_name' => 'api','name' => 'list permission']);
        Permission::create(['guard_name' => 'api','name' => 'show permission']);

        Permission::create(['guard_name' => 'api','name' => 'edit role']);
        Permission::create(['guard_name' => 'api','name' => 'delete role']);
        Permission::create(['guard_name' => 'api','name' => 'create role']);
        Permission::create(['guard_name' => 'api','name' => 'access role']);
        Permission::create(['guard_name' => 'api','name' => 'list role']);
        Permission::create(['guard_name' => 'api','name' => 'show role']);

        // create roles and assign existing permissions
        $role1 = Role::create(['guard_name' => 'api','name' => 'user']);
        $role1->givePermissionTo('access user');
        $role1->givePermissionTo('show user');
        $role1->givePermissionTo('list user');

        $role2 = Role::create(['guard_name' => 'api','name' => 'admin']);
        $role2->givePermissionTo('delete user');
        $role2->givePermissionTo('edit user');
        $role2->givePermissionTo('access user');
        $role2->givePermissionTo('show user');
        $role2->givePermissionTo('create user');
        $role2->givePermissionTo('list user');


        $role2->givePermissionTo('delete permission');
        $role2->givePermissionTo('edit permission');
        $role2->givePermissionTo('access permission');
        $role2->givePermissionTo('show permission');
        $role2->givePermissionTo('create permission');
        $role2->givePermissionTo('list permission');

        $role2->givePermissionTo('delete role');
        $role2->givePermissionTo('edit role');
        $role2->givePermissionTo('access role');
        $role2->givePermissionTo('show role');
        $role2->givePermissionTo('create role');
        $role2->givePermissionTo('list role');

        $role3 = Role::create(['guard_name' => 'api','name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($role1);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($role3);
    }
}
