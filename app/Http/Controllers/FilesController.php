<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function KakaoPhoto($filename)
    {
        $path = storage_path('app/public/kakao/calendar/');
        $file = $path . $filename;
    return response()->download($file);
    }
}
