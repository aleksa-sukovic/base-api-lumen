<?php

namespace Aleksa\UserGroup\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'user_groups';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    protected $guarded = ['id'];
}
