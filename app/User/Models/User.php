<?php

namespace Aleksa\User\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['full_name', 'email', 'birth_date', 'gender', 'reauth_requested_at'];
    protected $guarded = ['id', 'password'];
}
