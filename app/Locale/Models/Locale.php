<?php

namespace Aleksa\Locale\Models;

use Illuminate\Database\Eloquent\Model;
use Aleksa\Library\Services\LocaleService;
use Aleksa\Locale\Translation\Models\LocaleTranslation;

class Locale extends Model
{
    protected $table = 'locales';
    protected $primaryKey = 'id';
    protected $fillable = ['code', 'display'];
    protected $guarded = ['id'];

    public function translation()
    {
        return $this->hasOne(LocaleTranslation::class, 'locale_parent_id')->where('locale_id', '=', LocaleService::get()->id);
    }

    public function translations()
    {
        return $this->hasMany(LocaleTranslation::class, 'locale_parent_id');
    }
}
