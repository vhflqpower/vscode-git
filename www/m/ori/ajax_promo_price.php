<?php
include_once("./_common.php");


	$cs_id = $_GET['cs_id'];

if($cs_id){
	$sql = "SELECT teacher_name FROM cf_class_info  WHERE cs_id ='$cs_id'LIMIT 1";
	$result = mysql_query( $sql ) or die("Couldn t execute query.".mysql_error());
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$responce['flag'] = 'succ';
		$responce['rows'] = $row;	
}


	echo json_encode($responce);


?>



