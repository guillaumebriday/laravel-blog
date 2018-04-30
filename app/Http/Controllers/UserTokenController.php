<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Models\User;

class UserTokenController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = auth()->user();

        $this->authorize('api_token', $user);

        return view('users.token', ['user' => $user]);
    }

    /**
     * Generate a personnal access token for the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $user = auth()->user();

        $this->authorize('api_token', $user);

        $user->update([
            'api_token' => Token::generate()
        ]);

        return redirect()->route('users.token')->withSuccess(__('tokens.updated'));
    }
}
