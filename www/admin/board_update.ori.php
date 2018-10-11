<?
include_once("_common.php");




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

	$query ="insert into psj_board set
			wr_cat1 = '$cat1',
			wr_subject = '$wr_subject',
			wr_content = '$wr_content',
			mb_id = '$member[mb_id]',
			wr_name = '$member[mb_name]',
			wr_datetime = Now()";
		sql_query($query);

    $wr_id = sql_insert_id();



	$tmp_wr_id=abs(ip2long($_SERVER['REMOTE_ADDR'])); //IP를 임시로 사용;김철호071116
	if($tmp_wr_id >= 2147483647) //IP가 너무 클경우;김철호071116
	$tmp_wr_id=substr($tmp_wr_id,-9); //아홉자리로 자름;김철호07111

    // 첨부파일부모ID수정

	$bo_table = 'info';

	sql_query("update `psj_board_img` set wr_id = '$wr_id' where bo_table ='$bo_table' and wr_id = '$tmp_wr_id' ");


	}else if($oper=='edit'){


	$query ="update psj_board set
			wr_cat1 = '$cat1',
			wr_subject = '$wr_subject',
			wr_content = '$wr_content'
			
			where wr_id = '$wr_id'";
		sql_query($query);




	}else if($oper=='del'){


	$query ="delete from psj_board

			where wr_id = '$wr_id'";
		sql_query($query);


	$app_root = $_SERVER['DOCUMENT_ROOT'];
	$sql3 = " select wr_id,bf_datetime,bf_file from psj_board_img where bo_table = '$bo_table' and wr_id = '$wr_id'"; 
	    $result3 = sql_query($sql3); 
	    while ($row3 = sql_fetch_array($result3)) 
	    { 

		@unlink($app_root."/data/board/img/$bo_table/$row3[bf_file]");
		 sql_query(" delete from psj_board_img where bf_file='$row3[bf_file]'"); 
	    } 


		goto_url("./board_list.php?part=info");
	
	//sql_query("update `psj_board_img` set wr_id = '$wr_id' where bo_table ='$bo_table' and  wr_id='{$wr_id}' ");

	}





		goto_url("./board_view.php?wr_id=$wr_id&part=info");








?>