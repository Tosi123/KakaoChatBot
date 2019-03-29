<?php
function AlarmSend($phn_id, $callback, $msg_text)
{
    $alarm_table = "ALARM_SEND_AGT";
    $snd_dttm = date('YmdHis');
    if (mb_strlen($msg_text, "euc-kr") >= 89) {
        $msg_type = "LMS";
    } else {
        $msg_type = "SMS";
    }

    DB::table($alarm_table)->insert(
//        알림 발송 쿼리 입력
    );
}

function DuplicateChk($type)
{
    $duplicate_table = "ALARM_DUPLICATE_CHECK";
    $date = date('Ymd');                       //오늘 날짜 가져오기
    $time = date('H');                       //시간 06 포맷

    $chk_query = DB::table($duplicate_table)
        ->select('COUNT')
        ->where('SND_DT', $date)
        ->where('TIME', $time)
        ->where('TYPE', $type)
        ->orderBy('DETAIL_TIME', 'desc')
        ->first();

    if (!empty($chk_query)) {
        foreach ($chk_query as $paser) {
            $count = $paser;
        }
    } else {
        $count = "N";
    }
    return "$count";
}

function DuplicateAdd($type, $status, $rmk)
{
    $duplicate_table = "ALARM_DUPLICATE_CHECK";
    $date = date('Ymd');                       //오늘 날짜 가져오기
    $time = date('H');                       //시간 06 포맷
    $detail = date('YmdHis');

    DB::table($duplicate_table)->insert(
        ['SND_DT' => "$date", 'TIME' => "$time", 'COUNT' => "$status", 'TYPE' => "$type", 'DETAIL_TIME' => "$detail", 'RMK' => "$rmk"]
    );
}

function RandomCmpid($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $now = date('ymdHis');
    $result = $now . $randomString;
    return $result;
}

function FindUser($type)
{
    $user_table = "ALARM_USER";
    $find_user = array();
    $find_query = DB::table($user_table)
        ->select('PHN', 'CALL', 'ALARM_TYPE')
        ->where('USED', 'Y')
        ->get();

    if (!empty($find_query)) {
        foreach ($find_query as $paser) {
            $type_chk = explode(',', $paser->ALARM_TYPE);
            if (in_array("$type", $type_chk)) {
                $all_user = [
                    "phn" => $paser->PHN_ID,
                    "call" => $paser->CALLBACK];
                array_push($find_user, $all_user);
            }
        }
        return $find_user;
    }
}
