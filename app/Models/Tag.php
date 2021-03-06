<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends BaseModel
{

    protected $table = 'tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

    public function articlesTags()
    {
        return $this->hasMany(ArticleTag::class);
    }

    public function hotTags()
    {
        return $this->hasMany(HotTag::class);
    }

    public function tagLocales($localeId = null)
    {
        if ($localeId) {
            return $this->hasOne(TagLocale::class)->where('locale_id', $localeId);
        }

        return $this->hasMany(TagLocale::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($tag) {
            $tag->articlesTags()->delete();
            $tag->hotTags()->delete();
        });
    }

    public function visitLog()
    {
        return $this->morphMany(VisitedLog::class, 'relateTable');
    }
}
