<?php

namespace App\Services\Messaging;

use App\Repositories\Messaging\MessageRepository;
use App\Models\Message;

class MessageService
{
    protected $repo;

    public function __construct(MessageRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getConversations($user)
    {
        return $this->repo->getConversations($user->id);
    }

    public function getThread($user, string $partnerId)
    {
        return $this->repo->getThread($user->id, $partnerId);
    }

    public function sendMessage($user, array $data)
    {
        if ($user->id === $data['receiver_id']) {
            abort(422, 'You cannot send a message to yourself.');
        }

        return $this->repo->createMessage([
            'sender_id' => $user->id,
            'receiver_id' => $data['receiver_id'],
            'body' => trim($data['body']),
            'is_read' => false,
        ]);
    }

    public function markThreadRead($user, string $partnerId)
    {
        return $this->repo->markThreadRead($user->id, $partnerId);
    }

    public function clearConversationForMe($user, string $partnerId)
    {
        return $this->repo->clearConversationForMe($user->id, $partnerId);
    }

    public function editMessage($user, int $messageId, string $body)
    {
        $message = $this->repo->findMessageForEdit($messageId, $user->id);

        if (! $message) {
            abort(404, 'Message not found or cannot be edited.');
        }

        if ($message->created_at->diffInMinutes(now()) > 10) {
            abort(422, 'Message can only be edited within 10 minutes.');
        }

        return $this->repo->updateMessage($message, trim($body));
    }

    public function deleteForEveryone($user, int $messageId)
    {
        $this->repo->deleteForEveryone($messageId, $user->id);
    }

    public function deleteForMe($user, int $messageId)
    {
        $this->repo->deleteForMe($messageId, $user->id);
    }
}
