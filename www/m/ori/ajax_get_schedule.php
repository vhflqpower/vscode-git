<?php
include_once("./_common.php");


$br_id =  $_GET['br_id'];
$photo_date =  $_GET['photo_date'];

//if(isset($_POST['cat_level']) && $_POST['cat_level'] != ''){

   $sql = "select  b.pi_class_code from psj_payment a, psj_pay_item b where  a.pay_item_id = b.pi_id and   a.mb_cd = '$member[mb_cd]'";
	 $re = mysql_query($sql); 
	  $row = mysql_fetch_array($re);

	  $pi_class_code = $row['pi_class_code'];


echo "<option value=''>--선택하세요--</option>";
	// $query = "SELECT cs_id,cs_date,cs_stime,cs_etime FROM `cf_class_info` WHERE cs_date like '%$photo_date%'";	 
    // (select  c.pi_subject from psj_pay_item c where c.pi_id = a.subject_id) as class_name,
	 $query ="select 
					   a.cs_id,
					   a.cs_group_id,a.cs_stime,a.cs_etime,
					   (select d.code from psj_code d where d.p_id ='classItem' && d.part = '2' and d.code = a.subject_id ) as class_code,
					   (select b.cd_name from psj_code b where b.p_id ='classItem' && b.part = '2' and b.code = a.subject_id ) as class_name,
					   a.teacher_name,a.cs_date,
					   	(select  d.is_confirm from cf_class_group d where d.cg_no = a.cs_group_id) as confirm_yn
				from `cf_class_info` a  WHERE a.cs_date like '%$photo_date%'";
	 $res = mysql_query($query); 
	   while($row = mysql_fetch_array($res)){ 

					$cs_id = $row['cs_id'];

					$class_code = $row['class_code'];

					$class_name = $row['class_name'];
					$teacher_name = $row['teacher_name'];

					if($row['cs_stime'] && $row['cs_etime']){
					$stime1  = substr($row['cs_stime'],0,2);
					$stime2  = substr($row['cs_stime'],-2);
					$etime1  = substr($row['cs_etime'],0,2);
					$etime2  = substr($row['cs_etime'],-2);

					$tr_time = $stime1.':'.$stime2.'-'.$etime1.':'.$etime2;
				}


if($pi_class_code==$class_code){

		// $class_code

		echo "<option value='".$cs_id."'>".$tr_time."[".$class_name."]</option>";
}


	}







?>
