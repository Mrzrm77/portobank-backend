<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messaging\SendMessageRequest;
use App\Http\Requests\Messaging\EditMessageRequest;
use App\Services\Messaging\MessageService;

class MessageController extends Controller
{
    public function conversations(
        MessageService $service
    ) {
        return response()->json([
            'success' => true,
            'data' => $service->getConversations(auth()->user()),
        ]);
    }

    public function thread(
        string $partnerId,
        MessageService $service
    ) {
        return response()->json([
            'success' => true,
            'data' => $service->getThread(auth()->user(), $partnerId),
        ]);
    }

    public function send(
        SendMessageRequest $request,
        MessageService $service
    ) {
        $message = $service->sendMessage(
            auth()->user(),
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => $message,
        ]);
    }

    public function markThreadRead(
        string $partnerId,
        MessageService $service
    ) {
        $service->markThreadRead(
            auth()->user(),
            $partnerId
        );

        return response()->json([
            'success' => true,
            'message' => 'Thread marked as read.',
        ]);
    }

    public function clearConversation(
        string $partnerId,
        MessageService $service
    ) {
        $service->clearConversationForMe(
            auth()->user(),
            $partnerId
        );

        return response()->json([
            'success' => true,
            'message' => 'Conversation cleared.',
        ]);
    }

    public function edit(
        int $id,
        EditMessageRequest $request,
        MessageService $service
    ) {
        $message = $service->editMessage(
            auth()->user(),
            $id,
            $request->validated()['body']
        );

        return response()->json([
            'success' => true,
            'message' => 'Message updated.',
            'data' => $message,
        ]);
    }

    public function deleteForMe(
        int $id,
        MessageService $service
    ) {
        $service->deleteForMe(
            auth()->user(),
            $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Message deleted for you.',
        ]);
    }

    public function deleteForEveryone(
        int $id,
        MessageService $service
    ) {
        $service->deleteForEveryone(
            auth()->user(),
            $id
        );

        return response()->json([
            'success' => true,
            'message' => 'Message deleted for everyone.',
        ]);
    }
}
