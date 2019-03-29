<?php
$permit_table = "KAKAO_PERMIT_USER";
$time = date('YmdHis');                       //오늘 날짜 가져오기
$id = $user_info['user_key'];
$id_chk = AccessUser($id);

if (count($id_chk) == 0) {
    DB::table($permit_table)->insert(
        array('USER_ID' => DB::RAW("HEX(AES_ENCRYPT( '$id', SHA2('MTAG9cJTwRAtA5DU', 512)))"),
            'REQUEST_TIME' => "$time",
            'STATUS' => "S")
    );
    $msg = "계정 권한 등록 요청 완료 하였습니다.";
} else {
    switch ($id_chk[0]) {
        case 'Y':
            $msg = "이미 계정 권한 등록된 계정 입니다.";
            break;
        case 'M':
            $msg = "이미 계정 권한 등록된 계정 입니다.";
            break;
        case 'S':
            $msg = "계정 권한 등록 진행중 입니다.\n관리자에게 문의 바랍니다.";
            break;
        default:
            $msg = "알 수 없는 값입니다.\n관리자에게 문의 바랍니다.";
    }
}

ResponseJson($msg);

