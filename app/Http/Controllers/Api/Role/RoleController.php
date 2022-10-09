<?php

namespace App\Http\Controllers\Api\Role;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\Role\RoleResource;
use App\Services\Role\RoleService;

class RoleController extends ApiController
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $roles = $this->roleService
                ->roles()
                ->paginate($this->getLimitPerPage());
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        try {
            $role = $this->roleService
                ->createNewRole($request->validated());
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param int  $roleId
     *
     * @return \Illuminate\Http\Response
     */
    public function show($roleId)
    {
        try {
            $role = $this->roleService->getRoleById($roleId);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest  $request
     * @param int  $roleId
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $roleId)
    {
        try {
            $role = $this->roleService
                ->updateById($roleId, array_filter($request->validated()));
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $roleId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($roleId)
    {
        try {
            $this->roleService->deleteById($roleId);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return $this->respondObjectDeleted($roleId);
    }
}
