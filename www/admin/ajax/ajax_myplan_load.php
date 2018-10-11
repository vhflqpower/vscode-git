<?php
$app_path = "../.."; // common.php 의 상대 경로
include_once($app_path."/common.php");

	$id = $_GET["pn_id"];


	$grade_name[3] = '상';
	$grade_name[2] = '중';
	$grade_name[1] = '하';


	$sql = "SELECT * FROM psj_plan   where  pn_id='$id'";
	$result = sql_query($sql);
	$row = sql_fetch_array($result);

	$grade = $row['pn_grade'];
	$row['pn_content_view'] = nl2br($row['pn_content']);

	$row['pn_grade_name'] = $grade_name[$grade];

	if($row['pn_end_yn']=='Y'){ $row['end_yn_name'] = '완료';  }else if($row['pn_end_yn']=='N'){ $row['end_yn_name'] = '진행중'; }


	$responce['rows']= $row;
	$responce['flag']= 'succ';


	echo json_encode($responce);


?>

