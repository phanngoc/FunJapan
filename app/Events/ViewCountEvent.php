<?php

namespace App\Events;

use App\Models\ArticleLocale;
use Illuminate\Foundation\Events\Dispatchable;

class ViewCountEvent
{
    use Dispatchable;

    public $articleLocale;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ArticleLocale $articleLocale)
    {
        $this->articleLocale = $articleLocale;
    }
}
