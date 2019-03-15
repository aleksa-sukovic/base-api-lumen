<?php

namespace Aleksa\Locale\Translation\Models;

use Illuminate\Database\Eloquent\Model;
use Aleksa\Locale\Models\Locale;

class LocaleTranslation extends Model
{
    protected $table = 'locale_translations';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'locale_parent_id', 'locale_id'];
    protected $guarded = ['id'];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }
}
