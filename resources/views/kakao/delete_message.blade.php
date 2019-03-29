<?php
$permit_table = "KAKAO_PERMIT_USER";
$id = $user_info['user_key'];
$id_chk = AccessUser($id);

if (count($id_chk) != 0) {
    DB::table($permit_table)
        ->where(array(
            'USER_ID' => DB::RAW("HEX(AES_ENCRYPT( '$id', SHA2('MTAG9cJTwRAtA5DU', 512)))")
        ))
        ->delete();
    $msg = "계정 권한 삭제가 완료 되었습니다.";
} elseif (count($id_chk) == 0) {
    $msg = "허용된 계정 권한이 존재하지 않습니다.";
} else {
    $msg = "알 수 없는 값입니다.\n관리자에게 문의 바랍니다.";
}

ResponseJson($msg);