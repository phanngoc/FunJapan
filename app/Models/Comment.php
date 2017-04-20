<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends BaseModel
{

    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'content',
        'parent_id',
        'article_id',
        'article_locale_id',
        'user_id',
        'favorite_count',
    ];

    protected $appends = [
        'posted_time',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            $comment->articleLocale->increment('comment_count');
        });

        static::deleting(function ($comment) {
            $comment->articleLocale->decrement('comment_count', ($comment->children->count() + 1));
            $comment->children()->delete();
            $comment->favoriteComments()->delete();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }

    public function getPostedTimeAttribute()
    {
        return $this->created_at->format(trans('datetime.posted_time'));
    }

    public function canBeDeleted()
    {
        return $this->user_id == auth()->id();
    }

    public function favoriteComments()
    {
        return $this->hasMany(FavoriteComment::class, 'comment_id', 'id');
    }

    public function isFavorite()
    {
        if (!$this->favoriteComments->count() || !auth()->check()) {
            return false;
        }

        return $this->favoriteComments->where('user_id', auth()->id())->count() > 0;
    }

    public function articleLocale()
    {
        return $this->belongsTo(ArticleLocale::class);
    }
}
