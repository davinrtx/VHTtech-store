<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Permisos
        $permissions = [
            'view dashboard',
            'manage catalog',
            'manage orders',
            'manage repairs',
            'assign repairs',
            'manage customers',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Refrescar caché después de crear permisos
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Roles con permisos
        $super_admin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $super_admin->syncPermissions($permissions);

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(['view dashboard', 'manage catalog', 'manage orders', 'manage customers', 'manage settings']);

        $gerente = Role::firstOrCreate(['name' => 'gerente', 'guard_name' => 'web']);
        $gerente->syncPermissions(['view dashboard', 'manage catalog', 'manage orders', 'manage repairs', 'manage customers']);

        $vendedor = Role::firstOrCreate(['name' => 'vendedor', 'guard_name' => 'web']);
        $vendedor->syncPermissions(['view dashboard', 'manage catalog', 'manage orders', 'manage customers']);

        $tecnico = Role::firstOrCreate(['name' => 'tecnico', 'guard_name' => 'web']);
        $tecnico->syncPermissions(['view dashboard', 'manage repairs', 'assign repairs']);
    }
}
