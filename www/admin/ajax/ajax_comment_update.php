<?php
	include_once("./_common.php");


	$bo_table = $_POST['bo_table'];
	$mode = $_POST["mode"];
	$co_id = $_POST["idx"];
	$p_id = $_POST["p_id"];
	$co_content = $_POST["co_content"];
	$mb_name = $member['mb_name'];

//print_r($_POST); exit;

if($mode=='add'){


	$sql = "INSERT INTO psj_board_comment SET 
		bo_table='$bo_table',
		p_id='$p_id',
		wr_name='$mb_name',
		co_content = '$co_content',
		co_datetime =Now()";
	
	$result = sql_query($sql);
	$reponce['flag'] = 'succ';

}


if($mode=='edit'){


if($co_id){

	$sql = "UPDATE psj_board_comment SET co_content = '$co_content' WHERE seq = '$co_id'";
	$result = sql_query($sql);


}
	$reponce['flag'] = 'succ';

}


if($mode=='del'){

	$sql = "DELETE FROM psj_board_comment WHERE seq = '$co_id'";
	$result = sql_query($sql);

	$reponce['flag'] = 'succ';

}



	echo  json_encode($reponce);
	

?>

