<?php
include_once("./_common.php");


$pid =  $_GET['pid'];
$id =  $_GET['id'];

		echo "<button type='button' class='btn btn-default ' onclick=\"search_gubun('')\">전체보기</button>";
		$arr_info_gubun =  select_info_gubun($pid);
		foreach($arr_info_gubun as $key => $val){
		  echo  "<button type='button' class='btn btn-default' onclick=\"search_tab2('".$key."')\">$val[0]</button>";
	   }




?>
