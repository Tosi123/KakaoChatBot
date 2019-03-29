<?php
$loging = $user_info['url'] . "\tConnection\tIP=" . $user_info['client_ip'];
Log::info($loging);

$threshold_table = "SENSOR_THRESHOLD";      //센서 임계치 테이블
$data_table = "TEMPERATURE_DATA";           //데이터 테이블
$today = date('Ymd');                       //오늘 날짜 가져오기
$sensor_name = "TEMPERATURE";               //센서명

//DB::enableQueryLog();                       //DB로깅 시작
//$queryLogging = DB::getQueryLog($data_mainquery);
//echo $queryLogging;
/* MYSQL에서 온도센서 임계치 가져오기 */
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
?>

@include('sensor.temperature.php.data_if')