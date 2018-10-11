<?
include_once("./_common.php");

/*
	  $mb_id = $_POST['mb_id'];
	  $mb_name = $_POST['mb_name'];
	  $mb_birth = $_POST['mb_birth'];
	  $mb_hp = $_POST['mb_hp'];
	  $mb_email = $_POST['mb_email'];
	  $mb_homepage = $_POST['mb_homepage'];
	  $mb_password = $_POST['mb_password'];
*/


	$mb_id = trim(strip_tags(mysql_escape_string($_POST[mb_id])));
	$mb_birth = trim(strip_tags(mysql_escape_string($_POST[mb_birth])));
	$mb_password = trim(mysql_escape_string($_POST[mb_password]));
	$mb_name = trim(strip_tags(mysql_escape_string($_POST[mb_name])));
	$mb_nick = trim(strip_tags(mysql_escape_string($_POST[mb_nick])));
	$mb_email = trim(strip_tags(mysql_escape_string($_POST[mb_email])));
	$mb_homepage = trim(strip_tags(mysql_escape_string($_POST[mb_homepage])));



	$mb_hp = trim(strip_tags(mysql_escape_string($_POST['mb_hp'])));


	$mb_cd = str_replace("-","",$mb_hp);

	//$mb_cd = rand(10,100);

	$data = sql_fetch("select * from  psj_member where mb_id ='$mb_id' limit 1");



		if ($mb_password){
			$sql_password = " , mb_password = '".sql_password($mb_password)."' ";
		}

		$sql = "INSERT INTO  psj_member SET 
			
			mb_cd = '$mb_cd',
			mb_id = '$mb_id',
			mb_name = '$mb_name',
			mb_nick ='$mb_name',
			mb_birth = '$mb_birth',
			mb_hp = '$mb_hp',
			mb_email = '$mb_email',
			mb_homepage = '$mb_homepage',
			mb_level = '2',
			mb_memo_call ='',
	    		mb_status ='I',
			mb_regdate ='$mb_regdate',
			mb_part ='1',
			mb_datetime = Now()
			$sql_password";

		sql_query($sql);



        $responce['flag'] = 'succ';
	    $responce['message'] = '회원  정상적으로 이루어졌습니다.';

	

	echo json_encode($responce); 
	

//	header('Location: ./register_resultregister_result');
#	echo("<meta http-equiv='Refresh' content='0;  URL=./register_result.php'>");



?>
