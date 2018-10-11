<?
$app = "../"; // common.php 의 상대 경로
include_once($app ."/common.php");


$mb_id       = $_POST[input_id];
$mb_password = $_POST[input_pw];


$mb = get_member($mb_id);



if (!$mb[mb_id] || (sql_password($mb_password) != $mb[mb_password])) {
    alert("패스워드가 틀립니다.\\n\\n패스워드는 대소문자를 구분합니다.");
}


	$link = "./mypage_write.php";


	goto_url($link);



?>
