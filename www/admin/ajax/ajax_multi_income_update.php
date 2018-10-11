<?php
	include_once("./_common.php");



	$oper = $_POST['oper'];

	$mo_date = $_POST['mo_date'];
	$mo_price = $_POST['mo_price'];
	$mo_memo = $_POST['mo_memo'];

	$check_item = $_POST['checkArray'];
	$num = explode(",",$_POST['num']);
	$indate = explode(",",$_POST['in_date']);
	$part_val = explode(",",$_POST['part_val']);
	$income_cd = explode(",",$_POST['income_cd']);
	$outgo_cd = explode(",",$_POST['outgo_cd']);
	$price = explode(",",$_POST['price']);
	$memo = explode(",",$_POST['memo']);



if($oper =='multi_add'){


	for($i=0; $i < count($num); $i++){

	if($num[$i]){
		
		$c_num = $in_date[$i];
		$c_part = $part_val[$i];
		$c_price = $price[$i];
		$cat1_code = (0 < $income_cd[$i])?$income_cd[$i]:$outgo_cd[$i];
		$c_date = str_replace("/","-",$indate[$i]);
		$c_memo = $memo[$i];

		$query = "INSERT INTO psj_money set 
					mo_date = '$c_date',
					mo_part = '$c_part',
					mo_cat1 = '$cat1_code',
					mo_price = '$c_price',
					mo_memo = '$c_memo',
					mo_regdate = Now()
					
					";
		sql_query($query);

	}


	$reponce['flag'] ='succ';

	}
}



if($oper =='check_del'){

for ($i=0; $i<count($check_item); $i++){

 $sql = "DELETE FROM  psj_money WHERE mo_id = '$check_item[$i]'";
		sql_query($sql);

	}

	//	$qstr="";
	//	goto_url("./pc_map_write.php" . $qstr);

	$reponce['flag'] = 'succ';

}




if($oper =='edit'){

		$sql = "UPDATE psj_money set 
					mo_date = '$mo_date',
					mo_price = '$mo_price',
					mo_memo = '$mo_memo'
				 WHERE mo_id = '$mo_id'";
		sql_query($sql);



	$reponce['flag'] ='succ';

}






	echo  json_encode($reponce);
	

?>

