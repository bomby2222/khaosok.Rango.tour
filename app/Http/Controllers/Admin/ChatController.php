<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $chats = Chat::with('messages')->orderBy('last_message_at', 'desc')->get();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'chats' => $chats->map(function ($chat) {
                    $lastMsg = $chat->messages->last();
                    return [
                        'id' => $chat->id,
                        'session_id' => $chat->session_id,
                        'guest_name' => $chat->guest_name,
                        'unread_count' => $chat->messages->where('sender', 'user')->where('is_read', false)->count(),
                        'last_message' => $lastMsg ? $lastMsg->message : 'Started chat',
                        'last_time' => $chat->last_message_at ? \Carbon\Carbon::parse($chat->last_message_at)->diffForHumans() : '',
                        'messages_count' => $chat->messages->count(),
                    ];
                })
            ]);
        }

        return view('admin.chats.index', compact('chats'));
    }

    public function getConversation($id)
    {
        $chat = Chat::with('messages')->findOrFail($id);
        $chat->messages()->where('sender', 'user')->update(['is_read' => true]);

        return response()->json([
            'chat' => $chat,
            'messages' => $chat->messages->map(function ($msg) {
                return [
                    'id' => $msg->id,
                    'sender' => $msg->sender,
                    'message' => $msg->message,
                    'time' => $msg->created_at->format('H:i'),
                ];
            })
        ]);
    }

    public function reply(Request $request, $id)
    {
        $request->validate(['message' => 'required|string|max:1000']);
        $chat = Chat::findOrFail($id);

        $msg = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender' => 'admin',
            'message' => $request->message,
            'is_read' => true,
        ]);

        $chat->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $msg->id,
                'sender' => $msg->sender,
                'message' => $msg->message,
                'time' => $msg->created_at->format('H:i'),
            ]
        ]);
    }

    // แอดมินเปลี่ยนชื่อแชทของลูกค้า
    public function rename(Request $request, $id)
    {
        $request->validate(['guest_name' => 'required|string|max:100']);
        $chat = Chat::findOrFail($id);
        $chat->update(['guest_name' => trim($request->guest_name)]);

        return response()->json([
            'success' => true,
            'guest_name' => $chat->guest_name
        ]);
    }

    public function destroy($id)
    {
        $chat = Chat::findOrFail($id);
        $chat->delete();
        return redirect()->route('admin.chats.index')->with('success', 'Chat session removed.');
    }
}