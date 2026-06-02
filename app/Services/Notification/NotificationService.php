<?php

namespace App\Services\Notification;

use App\Repositories\Notification\NotificationRepository;

class NotificationService
{
    protected NotificationRepository $repository;

    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getNotifications($user)
    {
        $data = $this->repository->getLatestNotifications($user->id);

        return [
            'messages' => $data['messages'],
            'likes' => $data['likes'],
            'unread_count' => $this->repository->countUnreadMessages($user->id),
        ];
    }

    public function markAllRead($user): int
    {
        return $this->repository->markAllMessagesRead($user->id);
    }
}
