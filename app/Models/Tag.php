<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PopularSeries;
use App\Services\Admin\PopularSeriesService;

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

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($tag) {
            $tag->articlesTags()->delete();
            $tag->hotTags()->delete();
            $popularSeries = PopularSeries::where('link', $tag->id)
                ->where('type', strtolower(config('popular_series.type.tag')))->get();
            foreach ($popularSeries as $value) {
                PopularSeriesService::delete($value);
            }
        });
    }

    public function visitLog()
    {
        return $this->morphMany(VisitedLog::class, 'relateTable');
    }
}
