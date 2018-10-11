<?php
	include_once("./_common.php");


	$oper = $_POST["oper"];
	$mb_no = $_POST["mb_no"];
	$mb_name = $_POST["mb_name"];
	$co_id = $_POST["co_id"];
	$mb_hp = $_POST["mb_hp"];
	$mb_tel = $_POST["mb_tel"];
	$mb_email = $_POST["mb_email"];
	$mb_memo = $_POST["mb_memo"];
	$mb_2 = $_POST["levelname"];

if($oper=='add'){


	$sql = "INSERT INTO psj_member SET 
		mb_name ='$mb_name',
	          mb_hp = '$mb_hp',
	          mb_tel = '$mb_tel',
	          mb_email = '$mb_email',
	          mb_memo = '$mb_memo',
	          mb_1 = '$co_id',
	          mb_2 = '$mb_2',
		mb_level = '1',
		mb_status = '1'
		";
	$result = sql_query($sql);
	$reponce['flag'] = 'succ';



}


if($oper=='edit'){


if($mb_no){

	$sql = "UPDATE psj_member 
	           SET mb_name = '$mb_name',
	              mb_hp = '$mb_hp',
		    mb_tel = '$mb_tel',
	              mb_email = '$mb_email',
		    mb_memo = '$mb_memo',
	              mb_1 = '$co_id',
		    mb_2 = '$mb_2'
	       WHERE 
		    mb_no = '$mb_no'";
	$result = sql_query($sql);



}
	$reponce['flag'] = 'succ';

}




if($oper=='del'){

	$sql = "DELETE FROM psj_member WHERE mb_no = '$mb_no'";
	$result = sql_query($sql);


	$reponce['flag'] = 'succ';

}



	echo  json_encode($reponce);
	

?>

