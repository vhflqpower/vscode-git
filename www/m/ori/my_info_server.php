<?
include_once("_common.php");


	  $mb_no = $_POST['mb_no'];
	  $mb_name = $_POST['mb_name'];
	  $mb_birth = $_POST['mb_birth'];
	  $mb_hp = $_POST['mb_hp'];
	  $mb_email = $_POST['mb_email'];
	  $mb_homepage = $_POST['mb_homepage'];
	  $mb_3 = $_POST['mb_3'];
	  $mb_6 = $_POST['mb_6'];
	  $mb_7 = $_POST['mb_7'];
	  $mb_8 = $_POST['mb_8'];
	  $mb_9 = $_POST['mb_9'];
	  $mb_password = $_POST['mb_password'];



	if($mb_6 && $mb_7 && $mb_8 && $mb_9){


	$data = sql_fetch("select * from  g4_member where mb_no ='$mb_no' limit 1");


	$data2 = sql_fetch("select count(*)as cnt from  cc_planer_point where mb_id ='$member[mb_id]' and is_checked = 1 limit 1");

	if($data2[cnt] < 1){

	if(!$data['mb_6'] && !$data['mb_7'] && !$data['mb_8'] && !$data['mb_9']){

	$etc = iconv("euc-kr","utf-8",'플래너 정보수정 시 부여');

		$sql1 = "INSERT INTO cc_planer_point SET				
				mb_id = '$member[mb_id]',
				pp_point = '1000',
				pp_date = Now(),
				pp_type = '1',
				pp_etc = '$etc',
				is_checked = '1'";
	mysql_query($sql1);

		}
	}
}


		if ($mb_password){
			$sql_password = " , mb_password = '".sql_password($mb_password)."' ";
		}

		$sql = "UPDATE  `g4_member` SET 
			mb_name = '$mb_name',
			mb_birth = '$mb_birth',
			mb_hp = '$mb_hp',
			mb_email = '$mb_email',
			mb_homepage = '$mb_homepage',
			mb_datetime = Now(),
			mb_3 = '$mb_3',
			mb_6 = '$mb_6',
			mb_7 = '$mb_7',
			mb_8 = '$mb_8',
			mb_9 = '$mb_9'
			$sql_password
			WHERE mb_no = '$mb_no'";
		mysql_query($sql);

//	echo "<script>location.href='./my_info.php'</script>";
//	echo("<meta http-equiv='Refresh' content='0;  URL=./my_info.php'>");
header('Location: ./my_info.php');
?>
