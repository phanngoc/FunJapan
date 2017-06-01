<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmailService;
use App\Models\Notification;
use Carbon\Carbon;
use DB;

class SendEmailNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications email to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $prepareSelectRaw = [];
        foreach (config('notification.type') as $type => $value) {
            $prepareSelectRaw[] = 'count(CASE WHEN `type` = ' . $value . ' THEN 1 END) as `' . $type . '`';
        }

        $selectRaw = implode(', ', $prepareSelectRaw);

        $notificationsUser = Notification::with('user', 'targetItem')
            ->select('user_id', DB::raw($selectRaw))
            ->where('created_at', '>=', Carbon::now()->subHours(config('notification.time_send_mail')))
            ->where('status', config('notification.status.un_read'))
            ->groupBy('user_id')
            ->get();

        foreach ($notificationsUser as $notificationUser) {
            $data = [
                'name' => $notificationUser->user->name,
                'time' => config('notification.time_send_mail'),
            ];

            foreach (config('notification.type') as $type => $value) {
                $data[$type] = $notificationUser->$type > 0 ?
                    '<p>' . trans('web/email.notification_mail.messages.' . $type, [
                        'number' => $notificationUser->$type,
                    ]) . '</p>' : '';
            }

            EmailService::sendMail(
                config('user.mail_template.notification'),
                $notificationUser->user->email,
                $notificationUser->user->locale_id,
                $data
            );
        }
    }
}
