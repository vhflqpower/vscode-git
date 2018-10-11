<?
include_once("../common.php");



$mb_ip = $_SERVER['REMOTE_ADDR'];

$mb_id       = $_POST[input_id];
$mb_password = $_POST[input_pw];



if (!trim($mb_id) || !trim($mb_password)){


    alert("회원아이디나 패스워드가 공백이면 안됩니다.");
}


$mb = get_member($mb_id);




if (!$mb[mb_id] || (sql_password($mb_password) != $mb[mb_password])) {


	echo "<script>alert('가입된 회원이 아니거나 패스워드가 틀립니다.\\n\\n패스워드는 대소문자를 구분합니다.');history back();</script>";
  //  alert("가입된 회원이 아니거나 패스워드가 틀립니다.\\n\\n패스워드는 대소문자를 구분합니다.");

echo "????";

}




// 회원아이디 세션 생성
set_session('ss_mb_id', $mb[mb_id]);
// FLASH XSS 공격에 대응하기 위하여 회원의 고유키를 생성해 놓는다. 관리자에서 검사함 - 110106
set_session('ss_mb_key', md5($mb[mb_datetime] . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']));


// 3.26
// 아이디 쿠키에 한달간 저장


/*
if ($auto_login) {

    $key = md5($_SERVER[SERVER_ADDR] . $_SERVER[REMOTE_ADDR] . $_SERVER[HTTP_USER_AGENT] . $mb[emp_pw]);
    set_cookie('ck_mb_id', $mb[emp_no], 86400 * 31);
    set_cookie('ck_auto', $key, 86400 * 31);

} else {
    set_cookie('ck_mb_id', '', 0);
    set_cookie('ck_auto', '', 0);
}
*/


	if($remember_id){
	$cookie_id = $mb_id;

	 setcookie('cookie_id',$cookie_id,time()+864000,'/'); //time()+864000 => 쿠키의 유효기간을 설정하는 부분 30일정도
	 setcookie('cookie_pw',$cookie_pw,time()+864000,'/'); //time()+864000 
	}else{
	 setcookie('cookie_id','',0,'/');
	 setcookie('cookie_pw','',0,'/');
	}




echo $link;


exit;
	$link = "/admin/main.php";


	goto_url($link);
	//	$responce['flag'] = 'succ';
	//	$responce['msg2'] = '로그인 성공';


	//	putJson('succ', '성공');

	//echo json_encode($responce);



//goto_url($link);





?>
