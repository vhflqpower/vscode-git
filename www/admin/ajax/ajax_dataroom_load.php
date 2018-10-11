<?php
$app_path = "../.."; // common.php 의 상대 경로
include_once($app_path."/common.php");

	$id = $_GET["id"];


	$sql = "SELECT a.*,
		(select b.bo_subject from psj_board_config b where b.bo_table=a.bo_table) as bo_subject,
		(select c.pj_subject from psj_project c where c.pj_id=a.pj_id) as pj_subject
		FROM psj_board_file a  where a.seq='$id'";

	$result = sql_query($sql);
	$row = sql_fetch_array($result);

	$responce['rows']= $row;
	$responce['flag']= 'succ';


	echo json_encode($responce);


?>

