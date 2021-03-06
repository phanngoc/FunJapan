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
        'is_member_only',
        'category_id',
        'sub_category_id',
        'end_published_at',
        'content_type',
        'title_bg_color',
        'hide',
        'status',
    ];

    protected $appends = [
        'thumbnail_urls',
        'html_content',
        'is_show_able',
        'status_by_locale',
        'status_show_in_front',
        'url_photo',
        'is_top',
    ];

    protected $dates = [
        'published_at',
        'end_published_at',
    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function articleTags($limit = null, $blocked = true)
    {
        $results = $this->hasMany(ArticleTag::class);

        if ($blocked) {
            if ($limit) {
                return $results->limit($limit);
            }

            return $results;
        }

        $results = $results->whereHas('tag', function ($query) {
            $query->where('status', config('tag.status.un_block'));
        });

        if ($limit) {
            return $results->limit($limit);
        }

        return $results;
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function getStatusByLocaleAttribute()
    {
        if ($this->status == config('article.status.draft')) {
            return config('article.status_by_locale.draft');
        }

        if ($this->status == config('article.status.published')) {
            if ($this->published_at > Carbon::now()) {
                return config('article.status_by_locale.schedule');
            } elseif ($this->end_published_at < Carbon::now()) {
                return config('article.status_by_locale.stop');
            }

            return config('article.status_by_locale.published');
        }

        return config('article.status_by_locale.stop');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function tags($limit = null, $blocked = true)
    {
        $results = $this->belongsToMany(Tag::class, 'article_tags', 'article_locale_id', 'tag_id');

        if ($blocked) {
            if ($limit) {
                return $results->limit($limit);
            }

            return $results;
        }

        $results = $results->where('status', config('tag.status.un_block'));

        if ($limit) {
            return $results->limit($limit);
        }

        return $results;
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

    public function getUrlPhotoAttribute()
    {
        if ($this->photo) {
            if ($this->content_type == config('article.content_type.markdown')) {
                return $this->photo;
            }

            return ImageService::imageUrl(config('images.paths.article_content') . '/' . $this->photo);
        }

        return '';
    }

    // public function getCategoryAttribute()
    // {
    //     return isset($this->article) ? $this->article->category : '';
    // }

    public function getHtmlContentAttribute($value)
    {
        if ($this->content_type == config('article.content_type.markdown')) {
            return Markdown::convertToHtml($this->content);
        }

        return $this->content;
    }

    public function getShortTitle()
    {
        return Str::limit($this->title, config('article.limit_short_title'));
    }

    public function getShortSummary()
    {
        return Str::limit($this->summary, config('article.limit_short_summary'));
    }

    public function getIsShowAbleAttribute()
    {
        return Carbon::now()->gt(Carbon::parse($this->published_at)) && !$this->hide;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute()
    {
        if ($this->category_id) {
            return $this->category->name;
        }

        return '';
    }

    public function visitLog()
    {
        return $this->morphMany(VisitedLog::class, 'relate_table');
    }

    public function getStatusShowInFrontAttribute()
    {
        return $this->status_by_locale == config('article.status_by_locale.published') && !$this->hide;
    }

    public function getIsTopAttribute()
    {
        $today = Carbon::today(config('app.admin_timezone'));

        return TopArticle::where('article_locale_id', $this->id)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->count();
    }
}
