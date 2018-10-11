<?php // hspark
  include_once("common.php");
  include_once("./lib/member.class.php");


	$mem = new MEMBER();
	$arr_mem = $mem->select_member('5');
/*
	foreach($arr_mem as $key=>$val){
		echo  $key.'_'.$val['mb_name']."<=====key"."<br>";
	}
*/

	 $result =  $mem->update_member('박성주2','psj007');


?>
		
