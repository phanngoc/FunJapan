<?php

namespace App\Services;

use App\Mail\SendMail;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\App;
use Mail;

class EmailService
{

    public static function sendMail($mailKey, $emailTo, $localeId, $data = [])
    {
        $locale = App::getLocale();

        $template = MailTemplate::where('key', $mailKey)
            ->where('locale_id', $localeId)
            ->first();

        if (!$template) {
            return false;
        }

        try {
            Mail::to($emailTo)->queue(new SendMail($locale, $template->content, $template->subject, $data));

            return true;
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());

            return false;
        }
    }
}
