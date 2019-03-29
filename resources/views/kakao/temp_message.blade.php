<?php
function SelectData()
{
    $threshold_table = "SENSOR_THRESHOLD";      //센서 임계치 테이블
    $data_table = "TEMPERATURE_DATA";           //데이터 테이블
    $today = date('Ymd');                       //오늘 날짜 가져오기
    $sensor_name = "TEMPERATURE";               //센서명

    $threshold_query = DB::table($threshold_table)
        ->select('THRESHOLD_VALUE1', 'THRESHOLD_VALUE2', 'THRESHOLD_VALUE3', 'THRESHOLD_VALUE4')
        ->where('SENSOR_NAME', $sensor_name)
        ->where('USED_YN', 'Y')
        ->get();

    foreach ($threshold_query as $paser) {
        $threshold_values = [
            "temp_min" => $paser->THRESHOLD_VALUE1,
            "temp_max" => $paser->THRESHOLD_VALUE2,
            "hum_min" => $paser->THRESHOLD_VALUE3,
            "hum_max" => $paser->THRESHOLD_VALUE4];
    }
    /* MYSQL에서 현재시간 데이터 가져오기 */
    $data_subquery = DB::table($data_table)->where('DATE', $today)->max('TIME');
    $data_mainquery = DB::table($data_table)
        ->select('DATE', 'TIME', 'TEMPERATURE_AVERAGE', 'HUMIDITY_AVERAGE')
        ->where('DATE', $today)
        ->where('TIME', $data_subquery)
        ->get();

    foreach ($data_mainquery as $paser) {
        $data_values = [
            "date" => $paser->DATE,
            "time" => $paser->TIME,
            "temp" => $paser->TEMPERATURE_AVERAGE,
            "hum" => $paser->HUMIDITY_AVERAGE];
    }

    $text = "※서버실 상태 모니터링※\n";
    $text = $text . "=================\n";
    $text = $text . "( " . $data_values['date'] . " / " . $data_values['time'] . " )\n";
    $text = $text . "[현재 온도:" . $data_values['temp'] . "℃ ]\n[정상 범위:" . $threshold_values['temp_min'] . "℃~" . $threshold_values['temp_max'] . "℃]\n";
    $text = $text . "[현재 습도:" . $data_values['hum'] . "% ]\n[정상 범위:" . $threshold_values['hum_min'] . "%~" . $threshold_values['hum_max'] . "%]\n";
    $text = $text . "=================";
    return $text;
}

$id_chk = AccessUser($user_info['user_key']);

if (count($id_chk) == 0) {
    $msg = "권한 등록을 요청 해주시길 바랍니다.";
} else {
    switch ($id_chk[0]) {
        case 'Y':
            $msg = SelectData();
            break;
        case 'M':
            $msg = SelectData();
            break;
        case 'S':
            $msg = "권한 등록이 완료된 뒤 이용 바랍니다.";
            break;
        default:
            $msg = "알 수 없는 값입니다.\n관리자에게 문의 바랍니다.";
    }
}

ResponseJson($msg);