<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Permission\PermissionResource;
use App\Services\Role\RoleService;
use Illuminate\Database\QueryException;

class PermissionController extends ApiController
{
    /**
     * A constructor for services is used in this controller.
     *
     * @param RoleService $roleService Instance class.
     */
    public function __construct(protected RoleService $roleService)
    {
        parent::__construct();
    }

    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        try {
            $permissions = $this->roleService
                ->permissions()
                ->paginate($this->getLimitPerPage());
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return PermissionResource::collection($permissions);
    }
}
