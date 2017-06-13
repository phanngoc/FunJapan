<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class LogViewTagEvent
{
    use SerializesModels;

    public $localeId;
    public $tag;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($tag, $localeId)
    {
        $this->tag = $tag;
        $this->localeId = $localeId;
    }
}
