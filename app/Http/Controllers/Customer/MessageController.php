<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesan;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = \App\Models\Pesan::with('pengirim')
            ->where('penerima_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.messages.index', compact('messages'));
    }

    public function markAsRead(Request $request)
    {
        $pesan = \App\Models\Pesan::where('id', $request->id)
            ->where('penerima_id', Auth::id())
            ->firstOrFail();
            
        $pesan->update(['sudah_dibaca' => true]);

        return response()->json(['success' => true]);
    }
}
