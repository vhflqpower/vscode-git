<?php
	include_once("./_common.php");

	$bo_table = $_POST['bo_table'];	
	$seq = $_POST['seq'];

	$file_path = "../..";


if($_POST['oper']=='del' && $seq){

		 $res = sql_query("select bf_file  from psj_board_file where seq = '".$seq."'");
		 $row = sql_fetch_array($res);

		    @unlink($file_path.'/data/pms/'.$bo_table.'/'.$row['bf_file']);

		//    echo $file_path.'/data/pms/'.$bo_table.'/'.$row['bf_file'];

		$sql = "delete from psj_board_file where seq='$seq'";
		$result = sql_query( $sql );
		


	$responce['flag'] = 'succ';

}

	echo json_encode($responce);



?>





