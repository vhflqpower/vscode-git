<?
include_once("_common.php");



	$g5['board_file_table'] = 'psj_link_item';
	$g5['link_member_table'] = 'psj_link_mb';


	$bo_table = 'project';
	$tab_id = $_POST['tab_id'];
	$pj_id = $_POST['pj_id'];
	$co_id = $_POST['search_company'];
	$pj_sort = $_POST['pj_sort'];



	$wr_subject = '';
	if (isset($_POST['wr_subject'])) {
		$wr_subject = substr(trim($_POST['wr_subject']),0,255);
		$wr_subject = preg_replace("#[\\\]+$#", "", $wr_subject);
	}
	if ($wr_subject == '') {
		$msg[] = '<strong>제목</strong>을 입력하세요.';
	}

	$wr_content = '';
	if (isset($_POST['wr_content'])) {
		$wr_content = substr(trim($_POST['wr_content']),0,65536);
		$wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
	}
	if ($wr_content == '') {
		$msg[] = '<strong>내용</strong>을 입력하세요.';
	}




	if($oper=='add'){

	$query ="insert into psj_project set
			
			pj_subject = '$pj_subject',
			co_id ='$co_id',
			pj_open_date = '$pj_open_date',
			pj_content = '$pj_content'";
		sql_query($query);

	 $pj_id = sql_insert_id();


	}else if($oper=='edit'){


	$query ="update psj_project set
			pj_subject = '$pj_subject',
			co_id ='$co_id',
			pj_open_date = '$pj_open_date',
			pj_content = '$pj_content',
			pj_step = '$pj_step',
			pj_sort = '$pj_sort'
			
			where pj_id = '$pj_id'";
		sql_query($query);


	}



/* 관련 파일처리 START */

	$data = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$pj_id'");

	if( count($file_no) < $data['cnt']){
	$query ="delete from  {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$pj_id'";
	sql_query($query);
	}

	for ($i=0; $i<count($file_no); $i++) 
	{

		$row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$pj_id' and bf_no = '$i'");


		if ($row[cnt]) 
		{

		$sql = " update {$g5['board_file_table']}
					set
					
					bf_item = '$file_id[$i]',
					bf_sort = '$sort_id[$i]',
					bf_datetime = Now()
				  where bo_table = '$bo_table'
					and wr_id = '$pj_id'
					and bf_no = '$i' ";
		sql_query($sql);


		} 
		else 
		{

			$sql = " insert into {$g5['board_file_table']}
						set bo_table = '$bo_table',
							wr_id = '$pj_id',
							bf_no = '$i',
							bf_item = '$file_id[$i]',
							bf_sort = '$sort_id[$i]',
							bf_type = 'file',
							bf_datetime = Now()";
			sql_query($sql);

	
	
		}
	}


	if($oper=='del'){


	$query ="delete from psj_project

			where pj_id = '$pj_id'";
	
		sql_query($query);


		goto_url("./project_list.php&part=project");
	}

/* 관련 파일처리 END */







/* 관련 담당처리 START */

	$data = sql_fetch(" select count(*) as cnt from {$g5['link_member_table']} where li_part = 'project' and p_id = '$pj_id'");

	if( count($file_no) < $data['cnt']){
	$query ="delete from  {$g5['link_member_table']} where li_part = 'project' and wr_id = '$pj_id'";
	sql_query($query);
	}

	for ($i=0; $i<count($mb_no); $i++) 
	{

		$row = sql_fetch(" select count(*) as cnt from {$g5['link_member_table']} where li_part = 'project' and p_id = '$pj_id' and li_no = '$i'");


		if ($row[cnt]) 
		{

		$sql = " update {$g5['link_member_table']}
					set
					
					li_mb_no = '$mb_id[$i]',
					li_sort = '$li_sort[$i]',
					li_memo = '$li_memo[$i]',
					li_datetime = Now()
				  where li_part = 'project'
					and p_id = '$pj_id'
					and li_no = '$i' ";
		sql_query($sql);


		} 
		else 
		{

			$sql = " insert into {$g5['link_member_table']}
						set li_part = 'project',
							p_id = '$pj_id',
							li_no = '$i',
							li_mb_no = '$mb_id[$i]',
							li_sort = '$li_sort[$i]',
							li_memo = '$li_memo[$i]',
							li_datetime = Now()";
			sql_query($sql);

			//echo $sql;exit;
	
	
		}
	}



/* 관련 담당처리  END */


// 선택삭제
/*
	if($oper=='check_del'){

		$checkArray  = $_POST['checkArray'];

			for($i=0; $i<count($checkArray);$i++){
				$id = $checkArray[$i];

				if($id){
				$query="delete from psj_member where pj_id='$id'";
				sql_query($query);

			}

		}
	$responce['flag'] = 'succ';
	$responce['message'] = '성공';
	echo json_encode($responce);
	}
*/
//선택삭제 끝





		goto_url("./project_view.php?pj_id=$pj_id&part=project&tab_id=$tab_id");








?>