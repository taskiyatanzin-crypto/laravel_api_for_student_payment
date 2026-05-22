<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Staff extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'staff';

    protected $fillable = [
        'name',
        'user_name',
        'skill',
        'role',
        'email',
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}
