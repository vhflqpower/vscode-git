<?php
include_once("./_common.php");




	$br_id =  $_GET['br_id'];
	$photo_date =  $_GET['toDate'];
	$time =  $_GET['rhour'];
	$time1 = $time; 
	$tmp = $time + 1;
	$time2 =  $tmp;

	$sql = "SELECT  ms_no,ms_date,ms_title FROM cc_mb_schedule  WHERE ms_date = '$photo_date' and br_id = '$br_id' limit 1";
	$result = mysql_query( $sql ) or die("Couldn t execute query.".mysql_error());
	$data = mysql_fetch_array($result,MYSQL_ASSOC);



if($data['ms_title']){


		$responce['flag'] = 'succ';
		$responce['rows'] =$data;	

}else{

  $query = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '$time1' AND rhs_takepic_hour <= '$time2'";
  $res = mysql_query($query);
   $row = mysql_fetch_array($res);


		$responce['flag'] = 'succ';
		$responce['rows'] = $row;	


}




	echo json_encode($responce);



?>
