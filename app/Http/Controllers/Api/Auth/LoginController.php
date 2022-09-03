<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\JsonRespondController;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use JsonRespondController;

    /**
     * Log in a user and returns an accessToken.
     *
     * @param Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $isValid = $this->validateRequest($request);

        if ($isValid !== true) {
            return $isValid;
        }

        $email    = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // The user is active, not suspended, and exists.
            $user  = Auth::user();
            $token = $user->createToken('admin')->plainTextToken;

            return $this->respond(
                [
                    'access_token' => $token,
                    'token_type'   => 'Bearer',
                ]
            );
        }

        return $this->respondUnauthorized();
    }

    /**
     * Validate the request.
     *
     * @param Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|true
     */
    private function validateRequest(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'    => 'email|required',
                'password' => 'required|min:8',
            ]
        );

        if ($validator->fails()) {
            return $this->respondValidatorFailed($validator);
        }

        // Check if email exists. If not respond with an Unauthorized, this way a hacker
        // doesn't know if the login email exist or not, or if the password is wrong.
        $count = User::where('email', $request->input('email'))->count();

        if ($count === 0) {
            return $this->respondUnauthorized();
        }

        return true;
    }
}
