<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;

class MailTemplate extends Model
{
    protected $table = 'mail_templates';

    protected $fillable = [
        'key',
        'locale_id',
        'subject',
        'content',
    ];

    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }
}
