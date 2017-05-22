<?php

use Illuminate\Database\Seeder;
use App\Models\Locale;
use App\Models\MailTemplate;

class MailInviteSeeder extends Seeder
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

                        http://indonesia.fun-japan.jp/Account/Register?referralId={referralId}',
                ],
            ];

            $importData = array_merge($importData, $data);
        }

        MailTemplate::insert($importData);
    }
}
