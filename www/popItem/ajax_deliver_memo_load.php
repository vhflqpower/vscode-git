<?php
include_once("_common.php");

	$de_no = $_GET['de_no']; 


if($de_no){
	$sql = "SELECT * from tt_deliver_memo  WHERE de_no = '$de_no'";



	$result = sql_query( $sql );
	$row = sql_fetch_array($result);



		$responce['flag'] = 'succ';
		$responce['rows'] = $row;
	
}

	echo json_encode($responce);


?>



