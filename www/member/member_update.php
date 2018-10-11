<?
include_once("_common.php");




if($oper=='edit'){

	
	if($_POST[mb_password]){
	
    $sql_password = "";
    if ($mb_password)
        $sql_password = " , mb_password = '".get_encrypt_string($mb_password)."' ";


	$query ="update psj_member set
			mb_name = '$mb_name',
			mb_memo = '$mb_memo',
			mb_birth = '$mb_birth'
			$sql_password

			where mb_no = '$mb_no'";
	
		sql_query($query);



	}else{

	$query ="update psj_member set
			mb_name = '$mb_name',
			mb_memo = '$mb_memo',
			mb_birth = '$mb_birth'

			where mb_no = '$mb_no'";
	
		sql_query($query);


	}

}
		alert("회원 정보 수정 완료");

		goto_url("./mypage_write.php");








?>