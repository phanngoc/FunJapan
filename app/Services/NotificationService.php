<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Events\NotificationEvent;
use App\Models\Notification;
use App\Models\Locale;
use App\Models\Comment;
use Exception;

class NotificationService
{
    public static function sendNotification($senderId, $localeId, $type, $comment)
    {
        $notification = Notification::create([
            'user_id' => $comment->user_id,
            'sender_id' => $senderId,
            'type' => $type,
            'reference_id' => $comment->id,
            'locale_id' => $localeId,
        ]);

        $locale = Locale::find($localeId);

        if ($notification && $locale) {
            event(new NotificationEvent($notification, $locale));
        }
    }

    public static function getNotifications($userId, $localeId, $limit = 20)
    {
        $notifications = Notification::with('sender', 'targetItem', 'targetItem.articleLocale')
            ->where('user_id', $userId)
            ->where('locale_id', $localeId)
            // ->orderBy('status')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
        $unreadTotal = Notification::where('status', config('notification.status.un_read'))
            ->where('locale_id', $localeId)
            ->where('user_id', $userId)
            ->count();

        return [
            'notifications' => $notifications,
            'unreadTotal' => $unreadTotal,
        ];
    }

    public static function dismissNotifications($userId, $localeId)
    {
        return Notification::where('status', config('notification.status.un_read'))
            ->where('locale_id', $localeId)
            ->where('user_id', $userId)
            ->update(['status' => config('notification.status.read')]);
    }
}
