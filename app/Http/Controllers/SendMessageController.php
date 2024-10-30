<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    public function index()
    {
        // return 'haii';
        return view('send-message.index');
    }

    public function postMessage(Request $request)
    {
        $userName = 'User_01';
        $messageContent = $request->input('message');
        SendMessage::dispatch($userName, $messageContent);
        return response()->json(['status' => 'Message sent successfully.']);
    }
}
