<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionUserSeeder extends Seeder
{
    public function run(): void
    {
        // Module
        Permission::create(['name' => 'dashboard_permission', 'permission_description' => 'Grants access to view the system dashboard.']);
        Permission::create(['name' => 'rrhh_module_permission', 'permission_description' => 'Grants access to view RRHH sidebar module.']);
        Permission::create(['name' => 'inventory_module_permission', 'permission_description' => 'Grants access to view inventory sidebar module.']);
        Permission::create(['name' => 'loans_module_permission', 'permission_description' => 'Grants access to view loans sidebar module.']);
        Permission::create(['name' => 'pos_module_permission', 'permission_description' => 'Grants the ability to view existing records of POS within the system.']);

        // Admin / Sysadmin
        Permission::create(['name' => 'admin_permission', 'permission_description' => 'Grants the ability to do everything and whatever system can do excepts advance sysadmin things.']);
        Permission::create(['name' => 'sysadmin_permission', 'permission_description' => 'Grants the ability to do everything and whatever system can do.']);
        Permission::create(['name' => 'settings_permission', 'permission_description' => 'Grants the ability to system settings.']);
        Permission::create(['name' => 'logs_permission', 'permission_description' => 'Grants the ability to system logs.']);
        Permission::create(['name' => 'roles_permission', 'permission_description' => 'Grants the ability to system roles.']);
        Permission::create(['name' => 'permissions_permission', 'permission_description' => 'Grants the ability to system permissions.']);
        Permission::create(['name' => 'users_permission', 'permission_description' => 'Grants the ability to system users.']);

        // General CRUD permissions
        Permission::create(['name' => 'create_permission', 'permission_description' => 'Grants the ability to create new records within the system.']);
        Permission::create(['name' => 'read_permission', 'permission_description' => 'Grants the ability to view existing records within the system.']);
        Permission::create(['name' => 'update_permission', 'permission_description' => 'Grants the ability to modify existing records within the system.']);
        Permission::create(['name' => 'delete_permission', 'permission_description' => 'Grants the ability to delete records from the system.']);

        // Clients module
        Permission::create(['name' => 'clients_permission', 'permission_description' => 'Grants the ability to view existing records of clients within the system.']);
        Permission::create(['name' => 'services_permission', 'permission_description' => 'Grants the ability to view existing records of services within the system.']);
        Permission::create(['name' => 'categories_permission', 'permission_description' => 'Grants the ability to view existing records of categories within the system.']);
        Permission::create(['name' => 'products_permission', 'permission_description' => 'Grants the ability to view existing records of products within the system.']);
        Permission::create(['name' => 'loans_permission', 'permission_description' => 'Grants the ability to view existing records of loans within the system.']);
        Permission::create(['name' => 'sellers_permission', 'permission_description' => 'Grants the ability to view existing records of sellers within the system.']);
        Permission::create(['name' => 'fiscalfolios_permission', 'permission_description' => 'Grants the ability to view existing records of fiscal folios within the system.']);
        Permission::create(['name' => 'quotes_permission', 'permission_description' => 'Grants the ability to view existing records of quotes within the system.']);
        Permission::create(['name' => 'formats_permission', 'permission_description' => 'Grants the ability to view existing records of formats within the system.']);
        Permission::create(['name' => 'banks_permission', 'permission_description' => 'Grants the ability to view existing records of banks within the system.']);
        Permission::create(['name' => 'consignments_permission', 'permission_description' => 'Grants the ability to view existing records of consignments within the system.']);
        Permission::create(['name' => 'exports_permission', 'permission_description' => 'Grants the ability to export data from the system.']);

        $sysadmin_role = Role::create([
            'name' => 'sysadmin',
            'role_description' => 'Designed for users with full access and control over the system, allowing management of users, permissions, modules, settings and everything.',
            'guard_name' => 'web'
        ]);

        // Dar todos los permisos directamente
        $permissions = Permission::all();
        $sysadmin_role->givePermissionTo($permissions);

        // Crear usuarios
        $sysadmin_user = User::create([
            'name' => 'Carlos Rodriguez',
            'email' => 'admin@dev.com',
            'profile_photo' => '685b0547cc46a.png',
            'password' => bcrypt('Nightmare98'),
        ]);

        $sysadmin_user->assignRole($sysadmin_role);
    }
}
