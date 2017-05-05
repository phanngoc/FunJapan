<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Storage;
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Services\ImageService;
use Log;

class ArticleLocale extends BaseModel
{

    protected $table = 'article_locales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'locale_id',
        'article_id',
        'title',
        'content',
        'summary',
        'like_count',
        'comment_count',
        'share_count',
        'view_count',
        'published_at',
        'photo',
        'is_top_article',
        'recommended',
        'start_campaign',
        'end_campaign',
        'hide_always',
        'is_member_only',
        'is_popular',
    ];

    protected $appends = [
        'thumbnail_urls',
        'category_locale_name',
        'html_content',
        'is_show_able',
    ];

    protected $dates = [
        'published_at',
        'start_campaign',
        'end_campaign',
    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function getThumbnailUrlsAttribute($value)
    {
        if ($this->photo) {
            $results = [];

            try {
                foreach (config('images.dimensions.article_thumbnail') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.article_thumbnail') . '/' . $this->article_id . '/' . $this->locale_id . '/' . $this->photo;
                    } else {
                        $filePath = config('images.paths.article_thumbnail') . '/' . $this->article_id . '/' . $this->locale_id . '/' . $key . '_' . $this->photo;
                    }

                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                Log::debug($e);
            }
        }

        foreach (config('images.dimensions.article_thumbnail') as $key => $value) {
            $results[$key] = null;
        }

        return $results;
    }

    public function getCategoryLocaleNameAttribute($value)
    {
        return $this->article->category->categoryLocales->where('locale_id', $this->locale_id)->first()->name;
    }

    public function getHtmlContentAttribute($value)
    {
        return Markdown::convertToHtml($this->content);
    }

    public function getShortTitle()
    {
        return Str::limit($this->title, config('article.limit_short_title'));
    }

    public function getIsShowAbleAttribute()
    {
        return Carbon::now()->gt($this->published_at) && !$this->hide_always;
    }
}
