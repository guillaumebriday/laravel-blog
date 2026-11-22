<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name'])]
class Role extends Model
{
    use HasFactory;

    const ROLE_ADMIN = 'admin';

    const ROLE_EDITOR = 'editor';
}
