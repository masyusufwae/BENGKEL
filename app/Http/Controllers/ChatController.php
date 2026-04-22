<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Find contacts depending on role
        if ($user->role === 'pelanggan') {
            $contacts = User::whereIn('role', ['admin', 'mekanik'])->get();
        } elseif ($user->role === 'mekanik') {
            $contacts = User::whereIn('role', ['admin', 'pelanggan'])->get();
        } else { // admin
            $contacts = User::whereIn('role', ['mekanik', 'pelanggan'])->get();
        }

        // Loop to attach last message and unread count
        $userId = Auth::id();
        foreach ($contacts as $contact) {
            $lastMsg = Chat::where(function($q) use ($userId, $contact) {
                    $q->where('sender_id', $userId)->where('receiver_id', $contact->id);
                })
                ->orWhere(function($q) use ($userId, $contact) {
                    $q->where('sender_id', $contact->id)->where('receiver_id', $userId);
                })
                ->orderBy('created_at', 'desc')
                ->first();
                
            $contact->unread_count = Chat::where('sender_id', $contact->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
                
            $contact->last_message = $lastMsg ? $lastMsg->message : 'Belum ada pesan';
            $contact->last_message_time = $lastMsg ? $lastMsg->created_at->diffForHumans(null, true, true) : '';
        }

        // Sort putting unread on top
        $contacts = $contacts->sortByDesc('unread_count')->values();

        return view('chat.index', compact('contacts', 'user'));
    }

    public function fetchContacts()
    {
        $user = Auth::user();
        
        if ($user->role === 'pelanggan') {
            $contacts = User::whereIn('role', ['admin', 'mekanik'])->get();
        } elseif ($user->role === 'mekanik') {
            $contacts = User::whereIn('role', ['admin', 'pelanggan'])->get();
        } else {
            $contacts = User::whereIn('role', ['mekanik', 'pelanggan'])->get();
        }

        $userId = Auth::id();
        $summary = [];
        
        foreach ($contacts as $contact) {
            $lastMsg = Chat::where(function($q) use ($userId, $contact) {
                    $q->where('sender_id', $userId)->where('receiver_id', $contact->id);
                })
                ->orWhere(function($q) use ($userId, $contact) {
                    $q->where('sender_id', $contact->id)->where('receiver_id', $userId);
                })
                ->orderBy('created_at', 'desc')
                ->first();
                
            $unread = Chat::where('sender_id', $contact->id)
                ->where('receiver_id', $userId)
                ->where('is_read', false)
                ->count();
                
            $summary[] = [
                'id' => $contact->id,
                'name' => $contact->name,
                'role' => $contact->role,
                'last_message' => $lastMsg ? \Illuminate\Support\Str::limit($lastMsg->message, 30) : 'Belum ada pesan',
                'last_message_time' => $lastMsg ? $lastMsg->created_at->diffForHumans(null, true, true) : '',
                'unread_count' => $unread,
            ];
        }
        
        // Sort collection so unread floats to top
        usort($summary, function($a, $b) {
            return $b['unread_count'] <=> $a['unread_count'];
        });

        return response()->json($summary);
    }

    public function fetchMessages($contact_id)
    {
        $userId = Auth::id();
        
        // Mark as read
        Chat::where('sender_id', $contact_id)
            ->where('receiver_id', $userId)
            ->update(['is_read' => true]);

        $messages = Chat::where(function($q) use ($userId, $contact_id) {
                $q->where('sender_id', $userId)->where('receiver_id', $contact_id);
            })
            ->orWhere(function($q) use ($userId, $contact_id) {
                $q->where('sender_id', $contact_id)->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json($chat);
    }
    
    public function getUnreadCount()
    {
        $count = Chat::where('receiver_id', Auth::id())->where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }
}
