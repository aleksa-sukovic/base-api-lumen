<?php

namespace Aleksa\User\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['full_name', 'email', 'birth_date', 'gender', 'reauth_requested_at', 'group_id'];
    protected $guarded = ['id', 'password', 'activated'];

    public function group()
    {
        return $this->belongsTo('Aleksa\UserGroup\Models\UserGroup');
    }

    public function hasAdminPrivileges()
    {
        return $this->isSuperAdmin() || $this->isAdmin();
    }

    public function isSuperAdmin()
    {
        return $this->group->name === 'super-admin';
    }

    public function isAdmin()
    {
        return $this->group->name === 'admin';
    }

    public function isEditor()
    {
        return $this->group->name === 'editor';
    }

    public function isUser()
    {
        return $this->group->name === 'user';
    }

    public function isActivated()
    {
        return $this->activated;
    }
}
