<?php
include_once("./_common.php");


	$cs_id = $_POST['cs_id'];
	$mb_cd = $_POST['mb_cd'];



if($cs_id && $mb_cd){

	$sql = "SELECT count(*)as cnt FROM cf_absent  WHERE class_id ='$cs_id' && mb_cd = '$mb_cd' limit 1";
	
	$result = mysql_query( $sql ) or die("Couldn t execute query.".mysql_error());
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	
		$responce['flag'] = 'succ';
		$responce['rows'] = $row;	
	 //   $responce['message'] = '이미 존재합니다..';
}else{

		$row[cnt] = 0;
		$responce['flag'] = 'succ';
		$responce['rows'] = $row;	

}


	echo json_encode($responce);


?>



