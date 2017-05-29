<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class ActivityLogEvent
{
    use SerializesModels;
    public $user;
    public $request;
    public $sessionId;

    /**
     * ActivityLog constructor.
     * @param Request $request
     */
    public function __construct(Request $request, User $user = null, $sessionId = null)
    {
        $this->user = $user;
        $this->request = $request;
        $this->sessionId = $sessionId ? : $request->cookie('session_id');
    }
}
