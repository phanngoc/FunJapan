<?php

namespace App\Http\Controllers\Web;

use App\Services\NotificationService;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class NotificationsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function list()
    {
        if (auth()->check()) {
            $notifications = NotificationService::getNotifications(auth()->id(), $this->currentLocaleId);
            $htmlNotifications = View::make('layouts.includes._notification_header_list')
                ->with('notifications', $notifications['notifications'])
                ->render();

            return [
                'success' => true,
                'total' => $notifications['unreadTotal'],
                'htmlNotifications' => $htmlNotifications,
            ];
        }
    }

    public function dismiss()
    {
        if (auth()->check()) {
            return [
                'success' => NotificationService::dismissNotifications(auth()->id(), $this->currentLocaleId),
            ];
        }
    }
}
