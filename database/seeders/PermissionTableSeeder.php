<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'car-list',
            'car-create',
            'car-edit',
            'car-delete',
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'driver-list',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'driver-assign',
            'driver-unassign',
            'toll-list',
            'toll-create',
            'toll-delete',
            'toll-edit',
            'toll-pay',
            'ticket-list',
            'ticket-pay',
            'charges-list',
            'charges-create',
            'charges-delete',
            'charges-edit',
            'charges-pay',
         //PERMISSIONS FOR SUPER ADMIN
            'admin-ticket',
            'admin-list',
            'admin-tolls',
            'admin-pay',
  

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
