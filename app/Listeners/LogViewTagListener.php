<?php

namespace App\Listeners;

use App\Events\LogViewTagEvent;
use App\Libraries\Browser;
use App\Models\VisitedLog;
use Illuminate\Session\Store;
use Carbon\Carbon;

class LogViewTagListener
{
    private $key = 'view_tag_count';
    private $browser;
    private $session;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Browser $browser, Store $session)
    {
        $this->browser = $browser;
        $this->session = $session;
        $this->key = config('tag.view_tag_count', $this->key);
    }

    /**
     * Handle the event.
     *
     * @param  LogViewTagEvent  $event
     * @return void
     */
    public function handle(LogViewTagEvent $event)
    {
        $tag = $event->tag;
        $localeId = $event->localeId;
        $user = $this->getUser();

        if (!$this->isTagViewed($tag, $user)) {
            $this->updateActivityLog($tag, $localeId);

            $this->storeView($tag, $user);
        }
    }

    protected function getUser()
    {
        $userData = [];

        if ($loginedUser = auth()->user()) {
            $userData['user_id'] = $loginedUser->id;
            $userData['user_name'] = $loginedUser->name;
        } else {
            $userData['user_id'] = '0';
            $userData['user_name'] = 'Guest';
        }

        return $userData;
    }

    private function isTagViewed($tag, $user)
    {
        $viewed = $this->session->get($this->key, []);

        return array_key_exists($tag->id . '_' . $user['user_id'], $viewed);
    }

    private function storeView($articleLocale, $user)
    {
        $key = $this->key . '.' . $articleLocale->id . '_' . $user['user_id'];
        $this->session->put($key, time());
    }

    private function updateActivityLog($tag, $localeId)
    {
        $toDay = Carbon::toDay()->toDateString();

        $activity = VisitedLog::where('start_date', $toDay)
            ->where('relate_table_id', $tag->id)
            ->where('relate_table_type', config('visit_log.relate_type.tag'))
            ->first();

        if ($activity) {
            $activity->increment('count');
        } else {
            VisitedLog::create([
                'start_date' => $toDay,
                'relate_table_id' => $tag->id,
                'relate_table_type' => config('visit_log.relate_type.tag'),
                'locale_id' => $localeId,
            ]);
        }
    }
}
