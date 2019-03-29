<?php
function SelectData()
{
    $menu = array();
    $menu_table = "MENU_LIST";      //메뉴 리스트 테이블
    $list_query = DB::table($menu_table)
        ->select('MENU')
        ->where('TYPE', 'like', '%L%')
        ->inRandomOrder()
        ->inRandomOrder()
        ->inRandomOrder()
        ->inRandomOrder()
        ->inRandomOrder()
        ->limit(1)
        ->get();

    foreach ($list_query as $paser) {
        $menu = $paser->MENU;
    }

    $text = "(" . date("m/d") . ") 오늘의 점심 추천 메뉴 입니다.\n";
    $text = $text . "=================\n";
    $text = $text . $menu . " 축하드립니다.\n";
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