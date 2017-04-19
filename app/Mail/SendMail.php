<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\View;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $locale;
    private $layout;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($locale, $layout, $subject, $data)
    {
        $this->locale = $locale;
        $this->layout = $layout;
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $layoutPath = 'emails.' . $this->locale . '.' . $this->layout;

        return $this->subject($this->subject)
            ->view($layoutPath, $this->data);
    }
}
