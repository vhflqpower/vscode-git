<?
include_once("_common.php");

	$file_path = "..";
	$bo_table =  $_POST['bo_table'];
	$bf_content =  $_POST['bf_content'];
	$g5['board_file_table'] = 'psj_board_file';



//wr_id가 0이고 pj_id 값이 0인 마지막 seq 업데이트

/*

	$darg_file_check = sql_query("select seq,bf_source,bf_file from psj_board_file where wr_id = '0' and pj_id = '0' order by seq desc limit 1");
	$file_check_row = sql_fetch_array($darg_file_check);
	$seq = $file_check_row['seq'];
	$bf_file = $file_check_row['bf_file'];
	$bf_source = $file_check_row['bf_source'];
	$file_tmp = $file_path."/data/temp/".$bf_source;
	$dest_file = $file_path."/data/board/file/".$bo_table."/".$bf_file;

	if($seq){

		//temp파일을 실제 저장 위치로 copy 후 temp파일 삭제
		if(file_exists($file_tmp)){
			copy($file_tmp,$dest_file);
			@unlink($file_tmp);
		}


		//컬럼 wr_id 값 가공
		$row_no = sql_fetch("select count(*) as total  from {$g5['board_file_table']}");
		$mb_id = 'admin';
		$mb_name = '관리자';
		if($row_no['total'] ==''){
			$year = date("Ymd");
			$tmp_year =  substr($year,-6);
		    $file_id = $tmp_year.'00001';
		}else{
			$year2 = date("Ymd");
			$tmp_year2 =  substr($year2,-6);
			$count =  $row_no['total']+ 1;
			$file_id =  $tmp_year2.sprintf("%05d",$count);
		}


		$drag_sql = " update psj_board_file
							set
								bo_table = '$bo_table',
								pj_id = '$pj_id',
								wr_id = '$file_id',
								bf_content = '$bf_content',
								bf_download = 0,
								mb_id = '$mb_id',
								mb_name = '$mb_name',
								bf_datetime = Now()
							where
								seq = '$seq'";
					sql_query($drag_sql);
	}


*/



	goto_url("./dataroom_list.php?part=dataroom");



//삭제
	if($oper=='del'){


	$ori_bo_table = $_POST['ori_bo_table'];

	$row = sql_fetch(" select bf_file from `psj_board_file` where bo_table = '$ori_bo_table' and seq = '$seq' ");
		@unlink("$file_path/data/board/file/$ori_bo_table/$row[bf_file]");

	$query ="delete from  {$g5['board_file_table']} where seq = '$seq'";
		sql_query($query);


		goto_url("./dataroom_list.php?part=dataroom");
	}

?>