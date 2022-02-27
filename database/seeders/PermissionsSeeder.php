<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view all jobs']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'manager']);
        $role1->givePermissionTo('view all jobs');

        // give role to user
        $user = \App\Models\User::create([
        	'name' => 'Mohamed Gabr',
        	'email' => 'imohamedgabr@gmail.com',
        	'password' => bcrypt('123456')
        ]);
        $user->assignRole($role1);

    }
}
