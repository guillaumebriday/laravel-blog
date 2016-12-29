<?php

function user_name(\App\User $user) {
    return ucfirst(strtolower($user->name));
}
