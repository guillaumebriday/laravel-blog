<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use App\User;

class AuthenticateController extends Controller
{
    /**
    * Return the user's access token.
    *
    * @param  Request $request
    * @return \Illuminate\Http\Response
    */
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = User::where('email', $request->input('email'))->first();

            return (new UserResource($user))
                    ->additional(['meta' => [
                        'access_token' => $user->api_token
                    ]]);
        }

        return response()->json(['message' => 'This action is unauthorized.'], 401);
    }
}
