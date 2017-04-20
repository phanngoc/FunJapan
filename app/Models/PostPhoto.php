<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Services\ImageService;

class PostPhoto extends BaseModel
{

    protected $table = 'post_photos';

    const ORDER_BY_CREATED_DESC = 'created_desc';
    const ORDER_BY_CREATED_ASC = 'created_asc';
    const ORDER_BY_MOST_POPULAR = 'popular';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'article_locale_id',
        'photo',
        'content',
        'user_id',
        'status',
    ];

    protected $appends = [
        'photo_urls',
        'posted_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPostedTimeAttribute()
    {
        return $this->created_at->format(trans('datetime.posted_time'));
    }

    public function getPhotoUrlsAttribute()
    {
        if ($this->photo) {
            $results = [];

            try {
                foreach (config('images.dimensions.post_photo') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.post_photo') . '/' . $this->article_locale_id . '/' . $this->user_id . '/' . $this->photo;
                    } else {
                        $filePath = config('images.paths.post_photo') . '/' . $this->article_locale_id . '/' . $this->user_id . '/' . $key . '_' . $this->photo;
                    }

                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                Log::debug($e);
            }
        }

        foreach (config('images.dimensions.post_photo') as $key => $value) {
            $results[$key] = null;
        }

        return $results;
    }
}
