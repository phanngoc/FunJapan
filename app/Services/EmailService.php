<?php

namespace App\Services;

use App\Mail\SendMail;
use Illuminate\Support\Facades\App;
use Mail;

class EmailService
{

    public static function sendMail($layout, $emailTo, $subject, $data = [])
    {
        $locale = App::getLocale();

        try {
            Mail::to($emailTo)->queue(new SendMail($locale, $layout, $subject, $data));

            return true;
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());

            return false;
        }
    }
}
