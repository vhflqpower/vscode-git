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


    //ȸ�� �ڽ��� ������ ������ ��� ������ Ǯ���� ��찡 ���� 
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
		$msg[] = '<strong>����</strong>�� �Է��ϼ���.';
	}

	$wr_content = '';
	if (isset($_POST['wr_content'])) {
		$wr_content = substr(trim($_POST['wr_content']),0,65536);
		$wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
	}
	if ($wr_content == '') {
		$msg[] = '<strong>����</strong>�� �Է��ϼ���.';
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
			// ��ȸ�� �α� ī��Ʈupdate
			sql_query("update psj_count set info_write = info_write+1 where mb_id = '$member[mb_id]' ");
}


	$tmp_wr_id=abs(ip2long($_SERVER['REMOTE_ADDR'])); //IP�� �ӽ÷� ���;��öȣ071116
	if($tmp_wr_id >= 2147483647) //IP�� �ʹ� Ŭ���;��öȣ071116
	$tmp_wr_id=substr($tmp_wr_id,-9); //��ȩ�ڸ��� �ڸ�;��öȣ07111

    // ÷�����Ϻθ�ID����
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


//����
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