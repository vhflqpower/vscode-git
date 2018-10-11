<?
include_once('./_common.php');






	$bo_table = $_POST['bo_table'];
	$mode = $_POST["memo_oper"];
	$p_id = $_POST["p_id"];
	$co_content = $_POST["proc_memo"];
	$mb_name = $member['mb_name'];
	$mb_id = $member['mb_id'];




	$sql = "INSERT INTO psj_board_comment SET 
		bo_table='$bo_table',
		p_id='$p_id',
		wr_name='$mb_name',
		mb_id='$mb_id',
		co_content = '$co_content',
		co_datetime =Now()";
	//echo $sql; exit;
	$result = sql_query($sql);
	$reponce['flag'] = 'succ';



		goto_url("./view.php?bo_table=$bo_table&wr_id=$p_id");








?>