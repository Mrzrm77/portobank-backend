<?php

namespace App\Repositories\Notification;

use App\Models\Like;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository
{
    public function getLatestNotifications(int $userId): array
    {
        $messages = Message::where('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $likes = Like::whereHas('portfolio', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->where('user_id', '!=', $userId)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        return [
            'messages' => $messages,
            'likes' => $likes,
        ];
    }

    public function countUnreadMessages(int $userId): int
    {
        return Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function markAllMessagesRead(int $userId): int
    {
        return Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }
}
