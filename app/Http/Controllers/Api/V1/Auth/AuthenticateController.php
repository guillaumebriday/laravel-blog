<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    /**
     * Return the user's access token.
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = User::where('email', $request->input('email'))->first();

            return (new UserResource($user))
                ->additional(['meta' => [
                    'access_token' => $user->createToken('api_token')->plainTextToken
                ]]);
        }

        return response()->json(['message' => 'This action is unauthorized.'], 401);
    }
}
