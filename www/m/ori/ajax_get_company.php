<?php
include_once("./_common.php");


$tb_name = 'cc_company';


	$co_id = $_GET['co_id'];

if($co_id){

	$sql = "SELECT  *  FROM `$tb_name`  WHERE co_id ='$co_id' LIMIT 1";
}

	$result = mysql_query( $sql ) or die("Couldn t execute query.".mysql_error());
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
		$responce['flag'] = 'succ';
		$responce['rows'] = $row;	


	echo json_encode($responce);


?>



