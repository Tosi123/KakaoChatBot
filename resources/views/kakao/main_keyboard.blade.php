@include('kakao.public.custom_function')
<?php
$main = Keyboard();
$json = json_encode($main['keyboard']);
echo $json;