<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Show the Inbox (List of conversations)
     */
    public function index()
    {
        $userId = Auth::id();

        // Complex Query: Get the latest message for every unique conversation partner
        // This is a common pattern to build an "Inbox" list
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                // Group by the OTHER user's ID
                return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            });

        // Map the data to a cleaner format
        $inbox = $conversations->map(function ($msgs) use ($userId) {
            $lastMsg = $msgs->first(); // Since we ordered by desc, first is latest
            $partnerId = $lastMsg->sender_id === $userId ? $lastMsg->receiver_id : $lastMsg->sender_id;
            $partner = User::find($partnerId);

            return [
                'user' => $partner,
                'last_message' => $lastMsg,
                'unread_count' => $msgs->where('receiver_id', $userId)->whereNull('read_at')->count()
            ];
        })->filter(function ($item) {
            return $item['user'] !== null; // Remove if user deleted
        });

        return view('pages.messages.index', compact('inbox'));
    }

    /**
     * Show Chat with a specific User
     */
    public function show(User $user)
    {
        $currentUserId = Auth::id();

        // Prevent chatting with self
        if ($user->id === $currentUserId) {
            return redirect()->route('messages.index');
        }

        // Fetch conversation history
        $messages = Message::where(function ($q) use ($currentUserId, $user) {
            $q->where('sender_id', $currentUserId)
                ->where('receiver_id', $user->id);
        })
            ->orWhere(function ($q) use ($currentUserId, $user) {
                $q->where('sender_id', $user->id)
                    ->where('receiver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUserId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('pages.messages.show', compact('user', 'messages'));
    }

    /**
     * Send a Message
     */
    public function store(Request $request, User $user)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        // Check if blocked
        if (Auth::user()->isBlocked($user) || $user->isBlocked(Auth::user())) {
            return back()->with('error', 'You cannot message this user.');
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'body' => $request->body,
        ]);

        return back();
    }

    public function update(Request $request, Message $message)
    {
        if ($message->sender_id !== Auth::id()) abort(403);

        // Optional: 5 min limit
        if ($message->created_at->diffInMinutes(now()) > 5) {
            return back()->with('error', 'Message too old to edit.');
        }

        $request->validate(['body' => 'required|string']);
        $message->update(['body' => $request->body]);

        return back();
    }

    public function destroy(Message $message)
    {
        if ($message->sender_id !== Auth::id()) abort(403);
        $message->delete();
        return back();
    }
}
