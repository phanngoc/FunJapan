<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TopArticle extends Model
{
    protected $table = 'top_articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'article_locale_id',
        'start_date',
        'end_date',
    ];

    protected $appends = [
        'active',
    ];

    public function articleLocale()
    {
        return $this->belongsTo(ArticleLocale::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function getActiveAttribute()
    {
        $locale = $this->locale;
        if ($locale) {
            $isoCode = $locale->iso_code;
            $now = Carbon::now(trans('datetime.time_zone', [], $isoCode));
            $startDay = Carbon::parse($this->start_date, trans('datetime.time_zone', [], $isoCode));
            $endDay = Carbon::parse($this->end_date . ' 23:59:59', trans('datetime.time_zone', [], $isoCode));
            
            return ($now->gte($startDay)) && ($now->lte($endDay));
        }

        return false;
    }
}
