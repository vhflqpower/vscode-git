<?
include_once("_common.php");

	$file_path = "..";
	$bo_table =  'psj_board_data';//$_POST['bo_table'];
	$bf_content =  $_POST['bf_content'];
	$g5['board_file_table'] = 'psj_board_file';
	$oper = $_POST['oper'];




	$notice = '';
	if (isset($_POST['notice']) && $_POST['notice']) {
		$notice = $_POST['notice'];
	}

	$page = $_POST['page'];


    //회원 자신이 쓴글을 수정할 경우 공지가 풀리는 경우가 있음 
    if($oper=='edit' && !$member['admin'] && $board['bo_notice'] && in_array($wr['wr_id'], $notice_array)){
        $notice = 1;
    }

	$part = $_POST['part'];
	$bo_table = $_POST['bo_table'];

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

	$wr_num = get_next_num('psj_board_data');


	if($_POST['mb_id']){ 

	    $mb_id=$_POST['mb_id'] ;  
	    $res = sql_query("select mb_name from psj_member where mb_id='$mb_id'"); 
	    $row = sql_fetch_array($res);
	    $wr_name = $row['mb_name'];
	}else{ 
	    $mb_id=$member['mb_id'];
	    $wr_name=$member['mb_name'];

	     }


	$query ="insert into psj_board_data set
			wr_num ='$wr_num',
			wr_option = 'html1',
			wr_subject = '$wr_subject',
			wr_content = '$wr_content',
			mb_id = '$mb_id',
			wr_name = '$wr_name',
			wr_datetime = Now(),
			wr_1 = '$wr_1',
			wr_2 = '$wr_2'
			";
		sql_query($query);



    $wr_id = sql_insert_id();

        if ($notice) {
            $bo_notice = $wr_id.($board['bo_notice'] ? ",".$board['bo_notice'] : '');
            sql_query(" update {$g5['board_table']} set bo_notice = '{$bo_notice}' where bo_table = '{$bo_table}' ");
        }

		
if($bo_table=='info'){			
			// 조회자 로그 카운트update
			sql_query("update psj_count set info_write = info_write+1 where mb_id = '$member[mb_id]' ");
}


	$tmp_wr_id=abs(ip2long($_SERVER['REMOTE_ADDR'])); //IP를 임시로 사용;김철호071116
	if($tmp_wr_id >= 2147483647) //IP가 너무 클경우;김철호071116
	$tmp_wr_id=substr($tmp_wr_id,-9); //아홉자리로 자름;김철호07111

    // 첨부파일부모ID수정
	sql_query("update `psj_board_file` set wr_id = '$wr_id' where bo_table ='$bo_table' and wr_id = '$tmp_wr_id' ");



	goto_url("./data_view.php?wr_id=$wr_id&part=$part&bo_table=$bo_table");

	}else if($oper=='edit'){


	$query ="update psj_board_data set
			wr_cat1 = '$cat1',
			wr_cat2 = '$cate2',
			wr_subject = '$wr_subject',
			wr_content = '$wr_content',
			wr_1 = '$wr_1',
			wr_2 = '$wr_2'
			where wr_id = '$wr_id'";
		
		sql_query($query);

		$bo_notice = board_notice($board['bo_notice'], $wr_id, $notice);
		sql_query(" update {$g5['board_table']} set bo_notice = '{$bo_notice}' where bo_table = '{$bo_table}' ");


			$url = "./data_view.php?wr_id=$wr_id&part=$part&bo_table=$bo_table&page=$page";


		goto_url("./data_view.php?wr_id=$wr_id&part=$part&bo_table=$bo_table");
		//goto_url("./data_list.php?wr_id=$wr_id&part=$part&bo_table=$bo_table&page=$page");


	}


//삭제
	if($oper=='del'){


		$file_path = '/home/mta/www';
		 $res = sql_query("select bf_file,seq  from psj_board_file where bo_table = 'data' and wr_id='$wr_id'");
		 while($row = sql_fetch_array($res)){
		    @unlink($file_path.'/data/pms/data/'.$row['bf_file']);
			$sql = "delete from psj_board_file where seq='".$row[seq]."'";
			$result = sql_query( $sql );
		
		}


	   $query ="delete from psj_board_data where wr_id = '$wr_id'";
		sql_query($query);

		goto_url("./data_list.php?part=data");
	}





	if($_POST['comm_oper']=='add'){


	$sql3 = " select  co_no from psj_board_comment where bo_table = '$bo_table' and p_id = '$p_id' order by co_no desc"; 
	    $result3 = sql_query($sql3); 
	    $row3 = sql_fetch_array($result3);




	if( count($row3[co_no]) < 1)$co_no=0; else $co_no = $row3[co_no]+1;

	$query2 ="insert into psj_board_comment set
			
			bo_table = '$bo_table',
			p_id = '$p_id',
			co_no = '$co_no',
			co_content = '$co_content',
			mb_id = '$member[mb_id]',
			wr_name = '$member[mb_name]',
			co_datetime = Now()";

		sql_query($query2);

	$reponce['flag'] = 'succ';
	echo  json_encode($reponce);
		

	}





?>