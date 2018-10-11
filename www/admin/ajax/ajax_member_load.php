<?php
$app_path = "../.."; // common.php 의 상대 경로
include_once($app_path."/common.php");

	$id = $_GET["id"];


	$sql = "SELECT b.*,
	(select a.co_name from psj_company a where a.co_id = b.mb_1) as company,
	(select c.codename from psj_code c where c.code = b.mb_2 && pcode ='300000') as levelname
	FROM psj_member b  where b.mb_no='$id'";


	$result = sql_query($sql);
	$row = sql_fetch_array($result);

	$responce['rows']= $row;
	$responce['flag']= 'succ';


	echo json_encode($responce);


?>

