<?php

namespace App\Listeners;

use App\Events\ViewCountEvent;
use App\Libraries\Browser;
use Illuminate\Session\Store;

class ViewCountListener
{
    private $key = 'view_count';
    private $browser;
    private $session;

    /**
     * Create the event listener.
     *
     * @param Browser $browser
     */
    public function __construct(Browser $browser, Store $session)
    {
        $this->browser = $browser;
        $this->session = $session;
        $this->key = config('article.view_count_key', $this->key);
    }

    /**
     * Handle the event.
     *
     * @param  ViewCountEvent  $event
     * @return void
     */
    public function handle(ViewCountEvent $event)
    {
        $articleLocale = $event->articleLocale;
        $user = $this->getUser();

        if (!$this->isTopicViewed($articleLocale, $user)) {
            $articleLocale->increment('view_count');
            $this->storeView($articleLocale, $user);
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

    private function isTopicViewed($articleLocale, $user)
    {
        $viewed = $this->session->get($this->key, []);

        return array_key_exists($articleLocale->id . '_' . $user['user_id'], $viewed);
    }

    private function storeView($articleLocale, $user)
    {
        $key = $this->key . '.' . $articleLocale->id . '_' . $user['user_id'];
        $this->session->put($key, time());
    }
}
