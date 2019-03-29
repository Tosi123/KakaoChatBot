{{--알람 발송 함수 호출--}}
@include('sensor.temperature.php.alarm_send')

{{--비교 데이터 및 임계치 존재 여부 확인--}}
@if(empty($data_values['temp']) && empty($data_values['hum']))
    <H3>비교 데이터가 존재하지 않습니다</H3>
    @php
        exit;
    @endphp
@elseif(empty($threshold_values['temp_min']) && empty($threshold_values['temp_max']) && $threshold_values['hum_min'] && $threshold_values['hum_max'])
    <H3>입계치 데이터가 존재하지 않습니다</H3>
    @php
        exit;
    @endphp
@endif

{{--온도 및 습도 이상 여부 확인--}}
@if($data_values['temp'] < $threshold_values['temp_min'])
    <H3>온도가 너무 낮습니다.</H3>
    현재: {{ $data_values['temp'] }}℃ 정상범위 ({{ $threshold_values['temp_min'] }}℃ ~ {{ $threshold_values['temp_max'] }}℃)
    {{ TminLogic($data_values, $threshold_values) }}
@elseif($data_values['temp'] > $threshold_values['temp_max'])
    <H3>온도가 너무 높습니다.</H3>
    현재: {{ $data_values['temp'] }}℃ 정상범위 ({{ $threshold_values['temp_min'] }}℃ ~ {{ $threshold_values['temp_max'] }}℃)
    {{ TmaxLogic($data_values, $threshold_values) }}
@else
    <H3>온도가 정상 입니다.</H3>
    {{ OkLogic($data_values, "T") }}
@endif

@if($data_values['hum'] < $threshold_values['hum_min'])
    <H3>서버실이 너무 건조합니다.</H3>
    현재: {{ $data_values['hum'] }}% 정상범위 ({{ $threshold_values['hum_min'] }}% ~ {{ $threshold_values['hum_max'] }}%)
    {{ HminLogic($data_values, $threshold_values) }}
@elseif($data_values['hum'] > $threshold_values['hum_max'])
    <H3>서버실이 너무 습합니다.</H3>
    현재: {{ $data_values['hum'] }}% 정상범위 ({{ $threshold_values['hum_min'] }}% ~ {{ $threshold_values['hum_max'] }}%)
    {{ HmaxLogic($data_values, $threshold_values) }}
@else
    <H3>습도가 정상 입니다.</H3>
    {{ OkLogic($data_values, "H") }}
@endif


