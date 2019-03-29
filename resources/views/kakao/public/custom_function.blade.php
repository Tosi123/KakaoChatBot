<?php
function AccessUser($key)
{
    $permit_table = "KAKAO_PERMIT_USER";

    $return_value = DB::table($permit_table)
        ->where(array(
            'USER_ID' => DB::RAW("HEX(AES_ENCRYPT( '$key', SHA2('MTAG9cJTwRAtA5DU', 512)))")
        ))
        ->pluck('STATUS');

    return $return_value;
}

function Keyboard()
{
    $result = array('keyboard' =>
        array(
            'type' => 'buttons',
            'buttons' => ["온습도 확인", "점심 추천", "저녁 추천", "권한 등록", "권한 삭제"]
        )
    );
    return $result;
}

function ResponseJson($text)
{
    $response_key = Keyboard();
    $response_msg = array(
        'message' =>
            array(
                "text" => "$text"
            )
    );

    $response = array_merge($response_msg, $response_key);
    $enconding_json = json_encode($response);
    echo $enconding_json;
}

function ResponseJsonPhoto($text, $url, $x, $y)
{
    $response_key = Keyboard();
    $response_msg = array(
        'message' =>
            array(
                "text" => "$text",
                'photo' =>
                    array(
                        "url" => "$url",
                        "width" => $x,
                        "height" => $y
                    )
            )
    );

    $response = array_merge($response_msg, $response_key);
    $enconding_json = json_encode($response);
    echo $enconding_json;
}