<?php
include_once("./_common.php");


	$cs_id = $_POST['cs_id'];
	$mb_cd = $_POST['mb_cd'];



if($cs_id){

	$sql = "SELECT a.teacher_name,
				(select b.cd_name from psj_code b where  b.code = a.subject_id and b.p_id ='classItem' && b.part = '2' and b.use_yn ='Y') as subject
	FROM cf_class_info a  WHERE a.cs_id ='$cs_id' limit 1";
	
	$result = mysql_query( $sql ) or die("Couldn t execute query.".mysql_error());
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	
		$responce['flag'] = 'succ';
		$responce['rows'] = $row;	

}

	echo json_encode($responce);


?>



