<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;
use App\Services\ImageService;

class Result extends Model
{
    protected $table = 'results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'survey_id',
        'required_point_from',
        'required_point_to',
        'title',
        'photo',
        'description',
        'bottom_text',
    ];

    protected $appends = [
        'html_description',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function getHtmlDescriptionAttribute($value)
    {
        return Markdown::convertToHtml($this->description);
    }

    public function getPhotoUrlAttribute($value)
    {
        if ($this->photo) {
            $results = [];

            try {
                foreach (config('images.dimensions.result_survey') as $key => $value) {
                    if ($key == 'original') {
                        $filePath = config('images.paths.result_survey') . '/' . $this->id . '/' . $this->photo;
                    } else {
                        $filePath = config('images.paths.result_survey') . '/' . $this->id . '/' . $key . '_' . $this->photo;
                    }

                    $results[$key] = ImageService::imageUrl($filePath);
                }

                return $results;
            } catch (Exception $e) {
                Log::debug($e);
            }
        }
    }
}
