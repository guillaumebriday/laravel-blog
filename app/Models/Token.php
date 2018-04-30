<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
     * Return a unique personnal access token.
     */
    public static function generate(): string
    {
        do {
            $api_token = str_random(60);
        } while (User::where('api_token', $api_token)->exists());

        return $api_token;
    }
}
