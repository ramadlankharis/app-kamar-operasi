<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Membuat Permissions
         $permissions = [
            'create-master-status-operasi',
            'edit-master-status-operasi',
            'delete-master-status-operasi',
            'edit-urutan-master-status-operasi',
            'edit-master-ok',
            'update-status-ok',
            'create-master-operator',
            'edit-master-operator',
            'delete-master-operator'
         ];

         foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
         }

        // Membuat Roles
        $admin = Role::create(['name' => 'admin']);
        $operator = Role::create(['name' => 'operator']);
        // $viewer = Role::create(['name' => 'viewer']);

        // Assign permissions ke roles
        $admin->givePermissionTo(Permission::all());
        $operator->givePermissionTo(['update-status-ok']);

    }
}
