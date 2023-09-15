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
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $allPermissions = Permission::pluck('id')->toArray();
        $superAdminRole->syncPermissions($allPermissions);
        $superAdmin->assignRole([$superAdminRole->id]);

        // Create the Admin user with specific permissions
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $adminRole = Role::create(['name' => 'Admin']);
        
        // Define specific permissions for the admin user
        $adminPermissions = [
            'car-list',
            'driver-list',
            'toll-pay',
            'toll-list',
            'ticket-list',
            'ticket-pay',
            'charges-list',
            'charges-pay',
            'driver-assign',
            'driver-unassign',
            
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
