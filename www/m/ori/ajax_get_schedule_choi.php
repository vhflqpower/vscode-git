<?php
include_once("./_common.php");


$br_id =  $_GET['br_id'];
$photo_date =  $_POST['photo_date'];

//if(isset($_POST['cat_level']) && $_POST['cat_level'] != ''){


	echo "<option value=''>--선택하세요--</option>";

  $query = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '10' AND rhs_takepic_hour <= '11'";
  $res = mysql_query($query);
   $row = mysql_fetch_array($res);
   $cnt =  $row[cnt];


  $query2 = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '16' AND rhs_takepic_hour <= '17'";
  $res2 = mysql_query($query2);
   $row2 = mysql_fetch_array($res2);
   $cnt2 =  $row2[cnt];


	if($cnt == 0){ echo "<option value='10:00'>10:00</option>"; }
	if($cnt2 == 0){ echo "<option value='16:00'>16:00</option>"; }



?>
