<?php

namespace App\Services\Role;

use App\Models\Permission;
use App\Models\Role;
use App\Services\AbstractBaseService;
use DB;

class RoleService extends AbstractBaseService
{
    /**
     * Return all the roles.
     *
     * @return Role
     */
    public function roles()
    {
        return Role::query()->latest();
    }

    /**
     * Save a new role into the system and assigns permissions to it.
     *
     * @param array $roleData An array role data.
     *
     * @return Role
     */
    public function createNewRole($roleData)
    {
        $role = null;

        DB::transaction(
            function () use ($roleData, &$role) {
                $role = Role::create($roleData);

                $permissions = isset($roleData['permissions']) ? $roleData['permissions'] : [];
                $this->assignRolePermissions($role, $permissions);
            }
        );

        return $role;
    }

    /**
     * This function returns a role by its id
     *
     * @param int $id The id of the role you want to retrieve.
     *
     * @return Role
     */
    public function getRoleById($id)
    {
        return Role::query()
            ->whereId($id)
            ->firstOrFail();
    }

    /**
     * It deletes a role from the database
     *
     * @param int $roleId The id of the role you want to delete.
     *
     * @return bool.
     */
    public function deleteById($roleId)
    {
        $role = $this->getRoleById($roleId);

        $role->permissions()->detach();
        $role->delete();

        return true;
    }

    /**
     * Updates an existing role.
     *
     * @param int $roleId   The id of the role.
     * @param array $roleData An array role data.
     */
    public function updateById($roleId, $roleData)
    {
        $role = $this->getRoleById($roleId);

        DB::transaction(
            function () use ($roleData, &$role) {
                $permissions = isset($roleData['permissions']) ? $roleData['permissions'] : [];

                $this->assignRolePermissions($role, $permissions);

                $role->fill($roleData);
                $role->save();
            }
        );

        return $role;
    }

    /**
     * Assign a list of permission names to a role.
     *
     * @param Role $role                The role object to assign permissions to.
     * @param array $permissionNameArray An array of permission names.
     */
    protected function assignRolePermissions(Role $role, array $permissionNameArray = [])
    {
        $permissions         = [];
        $permissionNameArray = array_values($permissionNameArray);

        if ($permissionNameArray) {
            $permissions = Permission::query()
                ->whereIn('name', $permissionNameArray)
                ->pluck('id')
                ->toArray();
        }

        $role->permissions()->sync($permissions);
    }
}
