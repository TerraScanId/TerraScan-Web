<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ChatEvent;

class PusherController extends Controller
{
    public function broadcast(Request $request)
    {
        broadcast(new ChatEvent($request->get('message')))->toOthers();

        return view('broadcast', ['chat' => $request->get('message')]);
    }

    public function receive(Request $request)
    {
        return view('receive', ['chat' => $request->get('message')]);
    }
}
