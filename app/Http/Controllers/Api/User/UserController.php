<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends ApiController
{
    /**
     * A constructor for services is used in this controller.
     *
     * @param \App\Services\User\UserService $userService Instance class.
     */
    public function __construct(protected UserService $userService)
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
        $this->authorizeViewFor('users');

        try {
            $users = $this->userService
                ->users()
                ->paginate($this->getLimitPerPage());
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $this->authorizeEditFor('users');

        try {
            $user = $this->userService
                ->createUser($request->validated());
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return (new UserResource($user))
            ->additional(
                [
                    'data' => [
                        'permissions' => $user->permissions(),
                    ],
                ]
            );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest  $request
     * @param int  $userId
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $userId)
    {
        $this->authorizeEditFor('users');

        try {
            $user = $this->userService
                ->updateById($userId, array_filter($request->validated()));
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $userId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        $this->authorizeEditFor('users');

        try {
            $this->userService->deleteById($userId);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return $this->respondObjectDeleted($userId);
    }
}
