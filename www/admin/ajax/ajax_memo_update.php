<?php
	include_once("./_common.php");



	$mode = $_POST["mode"];
	$mb_id = $member['mb_id'];
	$me_id = $_POST['me_id'];
	$ca_name = $_POST['ca_name'];
	$ca_name_new = $_POST['ca_name_new'];
	$me_content = $_POST["me_content"];
	$is_notice = $_POST["is_notice"];


	$ca_name = ($ca_name_new)?$ca_name_new:$ca_name;


if($mode=='add'){


	$sql = "INSERT INTO psj_memo SET 

		mb_id='$mb_id',
		ca_name = '$ca_name',
		me_content = '$me_content',
		is_notice = '$is_notice',
		me_datetime =Now()";
	
	$result = sql_query($sql);
	$reponce['flag'] = 'succ';

}


if($mode=='edit'){


if($me_id){

	$sql = "UPDATE psj_memo SET ca_name = '$ca_name',me_content = '$me_content',is_notice = '$is_notice' WHERE me_id = '$me_id'";
	$result = sql_query($sql);

	$sql2 = "UPDATE psj_memo SET is_notice = '' WHERE me_id != '$me_id'";
	$result2 = sql_query($sql2);


}
	$reponce['flag'] = 'succ';

}

if($mode=='del'){

	$sql = "DELETE FROM psj_memo WHERE me_id = '$me_id'";
	$result = sql_query($sql);

	$reponce['flag'] = 'succ';

}

// 분류향목 삭제
if($mode=='ca_del'){

	$sql = "UPDATE psj_memo SET ca_name = '' WHERE ca_name = '$ca_name' and mb_id = '$member[mb_id]'";
	$result = sql_query($sql);

	$reponce['flag'] = 'succ';

}


	echo  json_encode($reponce);
	

?>

