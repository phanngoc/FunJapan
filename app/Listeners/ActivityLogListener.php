<?php

namespace App\Listeners;

use App\Events\ActivityLogEvent;
use App\Models\ActivityLog as ActivityLogModel;
use App\Libraries\Browser;
use Illuminate\Session\Store;
use Carbon\Carbon;

class ActivityLogListener
{
    private $browser;
    /**
     * ActivityLog constructor.
     * @param Browser $browser
     * @param Store $session
     */
    public function __construct(Browser $browser, Store $session)
    {
        $this->browser = $browser;
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  ActivityLog  $event
     * @return void
     */
    public function handle(ActivityLogEvent $event)
    {
        if ($event->request->ajax()) {
            //TODO : Handle with request is ajax
        } else {
            $now = time();
            $toDay = Carbon::createFromTimestamp($now, config('app.global_timezone'))->toDateString();

            $data = [
                'is_login' => false,
                'session_id' => $event->sessionId,
                'os' => $this->browser->getBrowser(),
                'ua' => $this->browser->getUserAgent(),
                'user_ip' => $event->request->ip(),
                'referral' => $event->request->headers->get('referer'),
                'last_access' => $now,
                'created_unix_time' => $now,
                'created_global_date' => $toDay,
            ];

            if ($event->user) {
                $oldActivity = ActivityLogModel::where('user_ip', $event->request->ip())
                    ->where('user_id', $event->user->id)
                    ->where('session_id', $event->sessionId)
                    ->where('created_global_date', $toDay)
                    ->orderBy('updated_at', 'DESC')
                    ->first();

                if (!$oldActivity) {
                    $userInfo = [
                        'user_id' => $event->user->id,
                        'is_login' => true,
                        'user_ranking' => $event->user->rank,
                        'new_user' => $event->user->isNewUser(),
                        'registered_user' => !$event->user->isNewUser(),
                    ];

                    ActivityLogModel::create(array_merge($data, $userInfo));
                } else {
                    $oldActivity->update(
                        [
                            'last_access' => $now,
                            'user_ip' => $event->request->ip(),
                            'referral' => $event->request->headers->get('referer'),
                        ]
                    );
                }
            } else {
                $oldActivity = ActivityLogModel::where('user_ip', $event->request->ip())
                    ->where('session_id', $event->sessionId)
                    ->whereNull('user_id')
                    ->where('created_global_date', $toDay)
                    ->orderBy('updated_at', 'DESC')
                    ->first();

                if (!$oldActivity) {
                    ActivityLogModel::create($data);
                } else {
                    $oldActivity->update(
                        [
                            'last_access' => $now,
                            'user_ip' => $event->request->ip(),
                            'referral' => $event->request->headers->get('referer'),
                        ]
                    );
                }
            }
        }
    }
}
