<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KakaoPlatform extends Controller
{
    public function GKeyboard()
    {
        return response()
            ->view('kakao.main_keyboard')
            ->header('Content-Type', 'application/json; charset=UTF-8');
    }

    public function PMessage(Request $request)
    {
        $user_info = [
            "user_key" => $request->input('user_key'),
            "type" => $request->input('type'),
            "content" => $request->input('content')];

        return response()
            ->view('kakao.main_message', compact('user_info'))
            ->header('Content-Type', 'application/json; charset=UTF-8');
    }

    public function DChatRoom()
    {
        return response("SUCCESS", 200)
            ->header('Content-Type', 'application/json; charset=UTF-8');
    }

    public function DPFriend()
    {
        return response("SUCCESS", 200)
            ->header('Content-Type', 'application/json; charset=UTF-8');
    }
}
