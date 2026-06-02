<?php

namespace App\Repositories\Messaging;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository
{
    public function createMessage(array $data): Message
    {
        return Message::create($data);
    }

    public function getThread($userId, string $partnerId): Collection
    {
        return Message::where(function ($query) use ($userId, $partnerId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $partnerId)
                ->where('deleted_for_sender', false);
        })
        ->orWhere(function ($query) use ($userId, $partnerId) {
            $query->where('sender_id', $partnerId)
                ->where('receiver_id', $userId)
                ->where('deleted_for_receiver', false);
        })
        ->orderBy('created_at', 'asc')
        ->get();
    }

    public function getConversations($userId): array
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('deleted_for_sender', false);
        })
        ->orWhere(function ($query) use ($userId) {
            $query->where('receiver_id', $userId)
                ->where('deleted_for_receiver', false);
        })
        ->orderBy('created_at', 'desc')
        ->get();

        $conversations = [];

        foreach ($messages as $message) {
            $partnerId = $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;

            if (! isset($conversations[$partnerId])) {
                $conversations[$partnerId] = [
                    'partner_id' => $partnerId,
                    'last_body' => $message->deleted_for_everyone ? 'Message deleted' : $message->body,
                    'last_at' => $message->created_at->toDateTimeString(),
                    'last_sender_id' => $message->sender_id,
                    'last_deleted' => $message->deleted_for_everyone,
                    'unread_count' => 0,
                ];
            }

            if ($message->receiver_id === $userId && ! $message->is_read && ! $message->deleted_for_receiver) {
                $conversations[$partnerId]['unread_count']++;
            }
        }

        return array_values($conversations);
    }

    public function markThreadRead($userId, string $partnerId): int
    {
        return Message::where('sender_id', $partnerId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->where('deleted_for_receiver', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    public function clearConversationForMe($userId, string $partnerId): int
    {
        return Message::where(function ($query) use ($userId, $partnerId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $partnerId)
                ->where('deleted_for_sender', false);
        })
        ->orWhere(function ($query) use ($userId, $partnerId) {
            $query->where('sender_id', $partnerId)
                ->where('receiver_id', $userId)
                ->where('deleted_for_receiver', false);
        })
        ->update([
            'deleted_for_sender' => true,
            'deleted_for_receiver' => true,
        ]);
    }

    public function findMessageForEdit(int $messageId, $userId)
    {
        return Message::where('id', $messageId)
            ->where('sender_id', $userId)
            ->where('deleted_for_everyone', false)
            ->first();
    }

    public function updateMessage(Message $message, string $body): Message
    {
        $message->body = $body;
        $message->edited_at = now();
        $message->save();

        return $message;
    }

    public function deleteForEveryone(int $messageId, $userId): void
    {
        $message = Message::where('id', $messageId)
            ->where('sender_id', $userId)
            ->where('deleted_for_everyone', false)
            ->firstOrFail();

        $message->body = '';
        $message->deleted_for_everyone = true;
        $message->save();
    }

    public function deleteForMe(int $messageId, $userId): void
    {
        $message = Message::findOrFail($messageId);

        if ($message->sender_id === $userId) {
            $message->deleted_for_sender = true;
        }

        if ($message->receiver_id === $userId) {
            $message->deleted_for_receiver = true;
        }

        $message->save();
    }

    public function getVisibleConversationPartners($userId, string $query = null)
    {
        return Message::where(function ($queryBuilder) use ($userId) {
            $queryBuilder->where('sender_id', $userId)
                ->where('deleted_for_sender', false);
        })
        ->orWhere(function ($queryBuilder) use ($userId) {
            $queryBuilder->where('receiver_id', $userId)
                ->where('deleted_for_receiver', false);
        })
        ->orderBy('created_at', 'desc')
        ->get();
    }
}
