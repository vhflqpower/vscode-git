<?
include_once("../common.php");
$app_path = ".."; // common.php 의 상대 경로
$mb_ip		 = $_SERVER['REMOTE_ADDR'];




// 이호경님 제안 코드
session_unset(); // 모든 세션변수를 언레지스터 시켜줌 
session_destroy(); // 세션해제함 


// 자동로그인 해제 --------------------------------
set_cookie("ck_mb_id", "", 0);
set_cookie("ck_auto", "", 0);
// 자동로그인 해제 end --------------------------------



    $link = '/admin/login.php';

goto_url($link);
?>