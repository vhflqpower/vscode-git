<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");

	
	$wr_id = $_REQUEST['wr_id'];
	$bo_table = $_REQUEST['bo_table'];




		$sql = "select * from psj_board_file where bo_table='$bo_table' and wr_id='$wr_id'";
		$result = sql_query( $sql );
	
	//echo $sql;
	$i=0;

	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {


		$row['bf_filesize'] = getFileSize($row['bf_filesize']);

		$responce['flag'] = 'succ';
		$responce['cell'][$i]= $row;
		$i++;
	}       
	echo json_encode($responce);



?>





