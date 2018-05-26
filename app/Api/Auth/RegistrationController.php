<?php

namespace App\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Registration Controller
 *
 * Deals with User Registration requests
 */
class RegistrationController extends Controller
{

    /**
     * POST /api/user
     *
     * Form-Data:
     * ['first_name', last_name', 'email', 'password']
     *
     * Return-Data
     * JSON instance of User Object
     *
     * @param Request $request
     * @return string
     */
    public function registerUser(Request $request)
    {
        $input = $request->all();

        # Create the User instance
        $user = new User();
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);

        # Generate the random code
        $verification_code = str_random(15);
        $user->verification_code = $verification_code;
        $user->verified = false;

        # Save the user and persist into the db
        $user->save();

        /** TODO: Set email service to send verification info */

        $this->response->addData('User', $user);
        return $this->response->response();
    }

    /**
     * POST /api/user/verify
     *
     * Form-Data:
     * ['verification_code', 'user_id']
     * user_id --> integer of user object id
     *
     * Return-Data
     * JSON instance of user object
     *
     * @param Request $request
     * @return array
     */
    public function verifyUser(Request $request)
    {
        $input = $request->all();

        # Verify User based on user-id sent
        $verification_code = $input['verification_code'];
        $user_id = $input['user_id'];

        try {
            $user = User::findOrFail($user_id);
        } catch (ModelNotFoundException $e) {
            return ['error' => 'Invalid User ID'];
        }
        if ($user->verification_code == $verification_code) {
            $user->verification_code = $verification_code;
            $user->verified = true;
            $user->save();

            $this->response->addData('User', $user);
            return $this->response->response();
        } else {
            return $this->response->errorResponse(new \Exception('Invalid Verification Code'));
        }

    }
}