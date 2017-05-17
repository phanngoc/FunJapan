<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;

class Survey extends Model
{
    protected $table = 'surveys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'locale_id',
        'title',
        'description',
        'type',
        'point',
    ];

    protected $appends = [
        'html_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function getHtmlDescriptionAttribute($value)
    {
        return Markdown::convertToHtml($this->description);
    }
}
