<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $locale;
    private $content;
    public $subject;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($locale, $content, $subject, $data)
    {
        $this->locale = $locale;
        $this->content = $content;
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
        $layoutPath = 'emails.email';

        foreach ($this->data as $key => $value) {
            if (str_contains($this->subject, '{' . $key . '}')) {
                $this->content = str_replace('{' . $key . '}', $value, $this->subject);
            }

            if (str_contains($this->content, '{' . $key . '}')) {
                $this->content = str_replace('{' . $key . '}', $value, $this->content);
            }
        }

        return $this->subject($this->subject)
            ->view($layoutPath, ['content' => $this->content]);
    }
}
