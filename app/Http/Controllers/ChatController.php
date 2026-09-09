<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    // 1. ดึงข้อความแชท
    public function fetchMessages(Request $request)
    {
        $sessionId = $request->input('session_id');
        if (!$sessionId) {
            return response()->json(['messages' => [], 'guest_name' => null]);
        }

        $chat = Chat::where('session_id', $sessionId)->first();
        if (!$chat) {
            return response()->json(['messages' => [], 'guest_name' => null]);
        }

        $messages = $chat->messages()->orderBy('created_at', 'asc')->get()->map(function ($msg) {
            return [
                'id' => $msg->id,
                'sender' => $msg->sender,
                'message' => $msg->message,
                'time' => $msg->created_at->format('H:i'),
            ];
        });

        return response()->json([
            'guest_name' => $chat->guest_name,
            'messages' => $messages
        ]);
    }

    // 2. เริ่มต้นแชท บันทึกชื่อลูกค้า และให้บอทตอบรับอัตโนมัติเป็นภาษาอังกฤษ
    public function initChat(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'guest_name' => 'required|string|max:100',
        ]);

        $guestName = trim($request->guest_name);

        $chat = Chat::firstOrCreate(
            ['session_id' => $request->session_id],
            [
                'guest_name' => $guestName,
                'last_message_at' => now(),
            ]
        );

        $chat->update([
            'guest_name' => $guestName,
            'last_message_at' => now(),
        ]);

        // ส่งข้อความต้อนรับอัตโนมัติหากเป็นการเปิดแชทครั้งแรก (ภาษาอังกฤษสไตล์ Luxury Travel)
        if ($chat->messages()->count() === 0) {
            $botGreeting = "Hello {$guestName}, welcome to Rango Tour! 🌿✨\nHow can our travel concierge assist you with Khao Sok rainforests & Cheow Lan Lake luxury floating resorts today?";
            
            ChatMessage::create([
                'chat_id' => $chat->id,
                'sender' => 'admin',
                'message' => $botGreeting,
                'is_read' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'guest_name' => $chat->guest_name,
        ]);
    }

    // 3. เปลี่ยนชื่อลูกค้า
    public function updateName(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'guest_name' => 'required|string|max:100',
        ]);

        $chat = Chat::where('session_id', $request->session_id)->first();
        if ($chat) {
            $chat->update(['guest_name' => trim($request->guest_name)]);
        }

        return response()->json([
            'success' => true,
            'guest_name' => trim($request->guest_name)
        ]);
    }

    // 4. ส่งข้อความจากลูกค้า
    public function sendMessage(Request $request)
    {
        $request->validate([
            'session_id' => 'required|string',
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::firstOrCreate(
            ['session_id' => $request->session_id],
            [
                'guest_name' => 'Traveler Guest',
                'last_message_at' => now(),
            ]
        );

        $chat->update(['last_message_at' => now()]);

        $msg = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender' => 'user',
            'message' => $request->message,
            'is_read' => false,
        ]);

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
}