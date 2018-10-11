<?php
	include_once("./_common.php");



	$mode = $_POST["mode"];
	$idx = $_POST["idx"];
	$p_id = $_POST["p_id"];
	


	$co_subject = '';
	if (isset($_POST['co_subject'])) {
		$co_subject = substr(trim($_POST['co_subject']),0,255);
		$co_subject = preg_replace("#[\\\]+$#", "", $co_subject);
	}
	if ($co_subject == '') {
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

	$sql = "UPDATE psj_board_comment SET 
				co_content = '$co_content' WHERE seq = '$idx'";
	$result = sql_query($sql);
}
	$reponce['flag'] = 'succ';



}


if($mode=='del'){

	$sql = "DELETE FROM psj_board_comment WHERE seq = '$idx'";
	$result = sql_query($sql);

	$reponce['flag'] = 'succ';

}



	echo  json_encode($reponce);
	

?>

