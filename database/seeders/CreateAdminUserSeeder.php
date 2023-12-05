<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    public function run()
    {
        // Create the Super Admin user with all permissions
        $superAdmin = User::create([
            'business' => 'S Admin',
            'f_name' => 'S',
            'l_name' => 'Admin',
            'business' => 's admin',
            'email' => 'sadmin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $superAdminRole = Role::create(['name' => 'S Admin']);
        $allPermissions = Permission::pluck('id')->toArray();
        $superAdminRole->syncPermissions($allPermissions);
        $superAdmin->assignRole([$superAdminRole->id]);

        //super Admin Panel 

        $superAdmin = User::create([
            'f_name' => 'Super',
            'l_name' => 'Admin',
            'business' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $user = Role::create(['name' => 'User']);
        $superPermissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'driver-list',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'admin-list',
            'admin-ticket',
            'admin-tolls',
            'toll-list',
            'toll-create',
            'toll-delete',
            'toll-edit',
            'charges-list',
            'charges-create',
            'charges-delete',
            'charges-edit',
            'admin-pay',
            
        ];
        
        // Create the permissions if they don't exist
        foreach ($superPermissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign specific permissions to the 'Admin' role
        $superAdminRole->syncPermissions($superPermissions);

        // Assign the 'Admin' role to the admin user
        $superAdmin->assignRole([$superAdminRole->id]);


        // Create the Admin user with specific permissions
        $admin = User::create([
            'f_name' => 'Admin',
            'l_name' => 'Admin',
            'business' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $adminRole = Role::create(['name' => 'Admin']);
        
        // Define specific permissions for the admin user
        $adminPermissions = [
            'car-list',
            'toll-pay',
            'toll-list',
            'ticket-list',
            'ticket-pay',
            'charges-list',
            'charges-pay',
            'driver-assign',
            'driver-unassign',
            'driver-list',
            'driver-create',
            'users-edit',
            'driver-edit',
            'driver-delete',
        ];

        // Create the permissions if they don't exist
        foreach ($adminPermissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Assign specific permissions to the 'Admin' role
        $adminRole->syncPermissions($adminPermissions);

        // Assign the 'Admin' role to the admin user
        $admin->assignRole([$adminRole->id]);
    }
}
