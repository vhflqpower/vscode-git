<?php
$app_path = "../.."; // common.php 의 상대 경로
include_once($app_path."/common.php");

	$id = $_GET["id"];

	$sql = "SELECT * FROM psj_money where mo_id='$id'";

	$result = sql_query($sql);
	$row = sql_fetch_array($result);

	$responce['rows']= $row;
	$responce['flag']= 'succ';


	echo json_encode($responce);


?>

