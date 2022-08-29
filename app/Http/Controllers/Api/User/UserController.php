<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\UserResource;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends ApiController
{
    /**
     * Constructor functions for services are used in this controller.
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
        try {
            $users = $this->userService->users()
                ->paginate($this->getLimitPerPage());
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\User\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            Log::error($e->getMessage());

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = $this->userService->getUser($id);
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return [
            $request,
            $id,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId)
    {
        try {
            $this->userService->deleteBy($userId);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (ValidationException $e) {
            Log::error($e->getMessage());

            return $this->respondValidatorFailed($e->validator);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return $this->respondObjectDeleted($userId);
    }
}
