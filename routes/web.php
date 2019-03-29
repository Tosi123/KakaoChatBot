<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//사내 서버실 온습도 체크
Route::get('/tempchk', 'TempController@GetIndex');

//카카오 플러스 친구
Route::get('/kakao/keyboard', 'KakaoPlatform@GKeyboard');
Route::post('/kakao/message', 'KakaoPlatform@PMessage');
Route::match(['delete', 'post'], '/kakao/friend/{id}', 'KakaoPlatform@DChatRoom');
Route::match(['delete', 'post'], '/kakao/friend', 'KakaoPlatform@DChatRoom');
Route::delete('/kakao/chat_room/{id}', 'KakaoPlatform@DChatRoom');
Route::delete('/kakao/chat_room', 'KakaoPlatform@DChatRoom');

//스토리지 사용
Route::get('/kakao/calendar/{filename}', 'FilesController@KakaoPhoto');