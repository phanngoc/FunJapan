<?php

use Illuminate\Database\Seeder;
use App\Models\Locale;
use App\Models\MailTemplate;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locales = Locale::all();

        $importData = [];

        foreach ($locales as $locale) {
            $data = [
                [
                    'key' => config('user.mail_template.invite_friends'),
                    'locale_id' => $locale->id,
                    'subject' => 'Ms./Mr {username} invites you Fun!Japan',
                    'content' => 'Invitation Letter has sent to you from {username}!

                        Fun!Japan bring you the most interesting news about Japanese culture - directly from Tokyo! Like our page and help us spread the word!

                        Please click and join to Fun!Japan from the link below, you will earn 5000 Bonus Points now! Our membership is GRATIS!

                        {url}',
                ],
                [
                    'key' => config('user.mail_template.after_register'),
                    'locale_id' => $locale->id,
                    'subject' => trans('web/email.register_mail_subject'),
                    'content' => '<p>Hi {name}, thanks for signing up for Fun! Japan.</p>
                        <p>We hope you enjoy reading articles and talking with other people who are also interested in Japan!</p>
                        <p>Please do not reply to this e-mail address. We can\'t receive.<p>',
                ],
                [
                    'key' => config('user.mail_template.forgot_password'),
                    'locale_id' => $locale->id,
                    'subject' => trans('web/email.lost_password_mail_subject'),
                    'content' => '<p>Someone requested an account recovery on Fun! Japan for {email}. If you did not request this, just ignore this email. Your account will be kept safe.</p>
                        <p>If you would like to reset your password, please click the following link and specify a new password.<p>
                        <p><a href="{url}">{url}</a><p>
                        <p>Please do not reply to this e-mail address. We can\'t receive.<p>',
                ],
                [
                    'key' => config('user.mail_template.notification'),
                    'locale_id' => $locale->id,
                    'subject' => trans('web/email.notification_mail.subject'),
                    'content' => '<p>Hello {name}. You received some notifications in the last {time} hours:<p>
                        {reply_comment}
                        {like_comment}
                    <p>Please do not reply to this e-mail address. We can\'t receive.<p>',
                ],
            ];

            $importData = array_merge($importData, $data);
        }

        MailTemplate::insert($importData);
    }
}
