<?php
	include_once("./_common.php");



	$mode = $_POST["mode"];
	$idx = $_POST["idx"];
	$p_id = $_POST["p_id"];
	
	
	//$co_content = $_POST["co_content"];

//print_r($_POST); exit;

	$subject = '';
	if (isset($_POST['subject'])) {
		$subject = substr(trim($_POST['subject']),0,255);
		$subject = preg_replace("#[\\\]+$#", "", $subject);
	}
	if ($subject == '') {
		$msg[] = '<strong>제목을</strong>을 입력하세요.';
	}



	$co_content = '';
	if (isset($_POST['co_content'])) {
		$co_content = substr(trim($_POST['co_content']),0,65536);
		$co_content = preg_replace("#[\\\]+$#", "", $co_content);
	}
	if ($co_content == '') {
		$msg[] = '<strong>내용</strong>을 입력하세요.';
	}



if($mode=='add'){


	$sql = "INSERT INTO psj_board_comment SET 
		bo_table='$bo_table',
		p_id='$p_id',
		co_content = '$co_content',
		co_datetime =Now()";
	$result = sql_query($sql);
	$reponce['flag'] = 'succ';

}


if($mode=='edit'){


if($idx){

	$sql = "UPDATE psj_issu_log SET 
				subject = '$subject',
				content = '$co_content' WHERE idx = '$idx'";
	$result = sql_query($sql);


}
	$reponce['flag'] = 'succ';

}


if($mode=='del'){

	$sql = "DELETE FROM psj_issu_log WHERE idx = '$idx'";
	$result = sql_query($sql);


	$reponce['flag'] = 'succ';

}



	echo  json_encode($reponce);
	

?>

