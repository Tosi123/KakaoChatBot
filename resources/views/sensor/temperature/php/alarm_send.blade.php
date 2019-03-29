@include('sensor.public.custom_function')

<?php
function OkLogic($data_arr, $type)
{
    if ($type == "T") {
        $alarm_msg = "(" . $data_arr['time'] . ") 서버실 온도가 정상화 되었습니다.";
        $duplicate = DuplicateChk("TEMP");
        if ($duplicate != "A") {
            DuplicateAdd("TEMP", "A", "SUCCESS");
            AllUserPush("$alarm_msg");
        } elseif ($duplicate == "N") {
            DuplicateAdd("TEMP", "A", "SUCCESS");
        }
    } elseif ($type == "H") {
        $alarm_msg = "(" . $data_arr['time'] . ") 서버실 습도가 정상화 되었습니다.";
        $duplicate = DuplicateChk("HUM");
        if ($duplicate != "A") {
            DuplicateAdd("HUM", "A", "SUCCESS");
            AllUserPush("$alarm_msg");
        } elseif ($duplicate == "N") {
            DuplicateAdd("HUM", "A", "SUCCESS");
        }
    }
}

function TminLogic($data_arr, $threshold_arr)
{
    $alarm_msg = "(" . $data_arr['time'] . ") 서버실 온도가 너무 낮습니다 (현재:" . $data_arr['temp'] . "℃/정상 범위:" . $threshold_arr['temp_min'] . "℃ ~ " . $threshold_arr['temp_max'] . "℃)";
    $duplicate = DuplicateChk("TEMP");
    if ($duplicate == "A" || $duplicate == "N") {
        DuplicateAdd("TEMP", "1", "TEMP_MIN");
        AllUserPush("$alarm_msg");
    } elseif (is_numeric($duplicate) && $duplicate <= 3) {
        $duplicate++;
        DuplicateAdd("TEMP", $duplicate, "TEMP_MIN");
        AllUserPush("$alarm_msg");
    }
}

function TmaxLogic($data_arr, $threshold_arr)
{
    $alarm_msg = "(" . $data_arr['time'] . ") 서버실 온도가 너무 높습니다 (현재:" . $data_arr['temp'] . "℃/정상 범위:" . $threshold_arr['temp_min'] . "℃ ~ " . $threshold_arr['temp_max'] . "℃)";
    $duplicate = DuplicateChk("TEMP");
    if ($duplicate == "A" || $duplicate == "N") {
        DuplicateAdd("TEMP", "1", "TEMP_MAX");
        AllUserPush("$alarm_msg");
    } elseif (is_numeric($duplicate) && $duplicate <= 3) {
        $duplicate++;
        DuplicateAdd("TEMP", $duplicate, "TEMP_MAX");
        AllUserPush("$alarm_msg");
    }
}

function HminLogic($data_arr, $threshold_arr)
{
    $alarm_msg = "(" . $data_arr['time'] . ") 서버실 습도가 너무 낮습니다 (현재:" . $data_arr['hum'] . "%/정상 범위:" . $threshold_arr['hum_min'] . "% ~ " . $threshold_arr['hum_max'] . "%)";
    $duplicate = DuplicateChk("HUM");
    if ($duplicate == "A" || $duplicate == "N") {
        DuplicateAdd("HUM", "1", "HUM_MIN");
        AllUserPush("$alarm_msg");
    } elseif (is_numeric($duplicate) && $duplicate <= 3) {
        $duplicate++;
        DuplicateAdd("HUM", $duplicate, "HUM_MIN");
        AllUserPush("$alarm_msg");
    }
}

function HmaxLogic($data_arr, $threshold_arr)
{
    $alarm_msg = "(" . $data_arr['time'] . ") 서버실 습도가 너무 높습니다. (현재:" . $data_arr['hum'] . "%/정상 범위:" . $threshold_arr['hum_min'] . "% ~ " . $threshold_arr['hum_max'] . "%)";
    $duplicate = DuplicateChk("HUM");
    if ($duplicate == "A" || $duplicate == "N") {
        DuplicateAdd("HUM", "1", "HUM_MIN");
        AllUserPush("$alarm_msg");
    } elseif (is_numeric($duplicate) && $duplicate <= 3) {
        $duplicate++;
        DuplicateAdd("HUM", $duplicate, "HUM_MIN");
        AllUserPush("$alarm_msg");
    }
}

function AllUserPush($msg)
{
    $user_list = FindUser("TEMP");

    foreach ($user_list as $user) {
        AlarmSend($user['phn_id'], $user['callback'], "$msg");
    }
}

