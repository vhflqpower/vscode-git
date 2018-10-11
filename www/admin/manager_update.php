<?
include_once("_common.php");


	$file_path = "..";
	 $bo_table =   $_POST['wr_bo_table']; //'data';
	$g5['board_file_table'] = 'psj_board_file';

	 $oper =   $_POST['oper'];	
	 $mb_no =   $_POST['mb_no'];
	 $mb_name =   $_POST['mb_name'];




    //$sql_password = "";
  //  if ($mb_password)
    //    $sql_password = " , mb_password = '".get_encrypt_string($mb_password)."' ";



	if($oper=='edit'){

	$query ="update psj_member set
			mb_name = '$mb_name'
			where mb_no = '$mb_no'";
	
		sql_query($query);


	//echo $query;

	}

	exit;
	
	if($oper=='del'){


	$bo_table = $_POST['bo_table_w'];


	$row = sql_fetch(" select bf_file from `psj_board_file` where bo_table = '$bo_table' and seq = '$seq' ");
		@unlink("$file_path/data/board/file/$bo_table/$row[bf_file]");


	$query ="delete from  {$g5['board_file_table']} where seq = '$seq'";
		sql_query($query);


		goto_url("./dataroom_list.php");
	}






		goto_url("./manager_list.php?wr_id=$wr_id&part=dataroom");








?>