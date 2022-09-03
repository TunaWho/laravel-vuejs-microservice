<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserService;
use App\Traits\JsonRespondController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    use JsonRespondController;

    /**
     * Constructor functions for services are used in this controller.
     *
     * @param \App\Services\User\UserService $userService Instance class.
     */
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();

            $user = $this->create(
                $this
                    ->validator($request->all())
                    ->validated()
            );

            return new UserResource($user);
        } catch (ValidationException $e) {
            return $this->respondValidatorFailed($e->validator);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($data)
    {
        return Validator::make(
            $data,
            [
                'last_name'  => 'required|max:255',
                'first_name' => 'required|max:255',
                'email'      => 'required|email|max:255|unique:users',
                'password'   => [
                    'required',
                    'confirmed',
                    PasswordRules::defaults(),
                ],
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array  $data
     *
     * @return User|\Illuminate\Http\Response
     */
    protected function create($data)
    {
        try {
            $user = $this->userService
                ->createUser($data);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());

            return $this->respondNotFound();
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return $this->respondInvalidQuery();
        }

        return $user;
    }
}
