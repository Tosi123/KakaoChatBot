@include('kakao.public.custom_function')
@php
    $log_txt = $user_info['url']. "\tConnection\tUSER=" . $user_info['user_key'] . "\tCONTENT=" . $user_info['content'];
    Log::info($log_txt);
@endphp

@if($user_info['content'] == "온습도 확인")
    @include('kakao.temp_message')
@elseif($user_info['content'] == "점심 추천")
    @include('kakao.lunch_message')
@elseif($user_info['content'] == "저녁 추천")
    @include('kakao.dinner_message')
@elseif($user_info['content'] == "권한 등록")
    @include('kakao.insert_message')
@elseif($user_info['content'] == "권한 삭제")
    @include('kakao.delete_message')
@else
    {{ ResponseJson("지원하지 않는 명령어 입니다.") }}
@endif