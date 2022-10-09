<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use DB;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $admin       = Role::whereName('Admin')->first();

        $permissions->map(
            fn ($permission) => DB::table('role_permissions')->insert([
                'role_id'       => $admin->id,
                'permission_id' => $permission->id,
            ])
        );

        $editor = Role::whereName('Editor')->first();

        $permissions->map(
            fn ($permission) => !in_array($permission->name, ['edit_roles']) ?
                    DB::table('role_permissions')->insert([
                        'role_id'       => $editor->id,
                        'permission_id' => $permission->id,
                    ])
                : []
        );

        $viewer = Role::whereName('Viewer')->first();

        $viewerRoles = [
            'view_users',
            'view_roles',
            'view_products',
            'view_orders',
        ];

        $permissions->map(
            fn ($permission) => in_array($permission->name, $viewerRoles) ?
                    DB::table('role_permissions')->insert([
                        'role_id'       => $viewer->id,
                        'permission_id' => $permission->id,
                    ])
                : []
        );
    }
}
