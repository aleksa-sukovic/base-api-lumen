<?php

namespace Aleksa\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    protected $table      = 'locales';
    protected $primaryKey = 'id';
    protected $fillable   = ['code', 'display'];
    protected $guarded    = ['id'];
}
