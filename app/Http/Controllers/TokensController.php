<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Token;

class TokensController extends Controller
{
    /**
    * Generate a personnal access token for the specified resource in storage.
    *
    * @param  Request $request
    * @param  User $user
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request, User $user)
    {
        $this->authorize('api_token', $user);

        $user->update([
            'api_token' => Token::generate()
        ]);

        return redirect()->route('users.edit', $user)->withSuccess(__('tokens.created'));
    }

    /**
    * Destroy a personnal access token for the specified resource in storage.
    *
    * @param  User $user
    * @return \Illuminate\Http\Response
    */
    public function destroy(User $user)
    {
        $this->authorize('api_token', $user);

        $user->update(['api_token' => null]);

        return redirect()->route('users.edit', $user)->withSuccess(__('tokens.deleted'));
    }
}
