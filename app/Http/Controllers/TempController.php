<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempController extends Controller
{
    public function GetIndex(Request $request)
    {
        $user_info = [
            "client_ip" => $request->ip(),
            "url" => $request->fullUrl(),
            "header" => $request->header()];
        return view('sensor.temperature.index', compact('user_info'));
    }
}
