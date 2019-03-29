@extends('layouts.html_skel')
@section('title')
    Hello, {{ $user_info['client_ip'] }}
@endsection

@section('content')
    @include('sensor.temperature.php.data_select')
@endsection