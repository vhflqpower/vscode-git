<?php
include_once("./_common.php");


$pid =  $_GET['pid'];
$id =  $_GET['id'];


if($pid){

	echo "<option value=''>--선택하세요--</option>";
		$arr_info_gubun =  select_info_gubun($pid);
		foreach($arr_info_gubun as $key => $val){
		
		if($key==$id){ $SELECTED = 'selected';}else{  $SELECTED = '';  }
		
		echo "<option value='$key' $SELECTED>$val[0]</option>";

		} 

	}





?>
