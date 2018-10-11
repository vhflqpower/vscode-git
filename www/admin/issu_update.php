<?
include_once("_common.php");




	$is_subject = '';
	if (isset($_POST['is_subject'])) {
		$is_subject = substr(trim($_POST['is_subject']),0,255);
		$is_subject = preg_replace("#[\\\]+$#", "", $is_subject);
	}
	if ($is_subject == '') {
		$msg[] = '<strong>제목</strong>을 입력하세요.';
	}

	$is_content = '';
	if (isset($_POST['is_content'])) {
		$is_content = substr(trim($_POST['is_content']),0,65536);
		$is_content = preg_replace("#[\\\]+$#", "", $is_content);
	}
	if ($is_content == '') {
		$msg[] = '<strong>내용</strong>을 입력하세요.';
	}


	$co_subject = '';
	if (isset($_POST['co_subject'])) {
		$co_subject = substr(trim($_POST['co_subject']),0,255);
		$co_subject = preg_replace("#[\\\]+$#", "", $co_subject);
	}
	if ($proc_memo == '') {
		$msg[] = '<strong>이슈내역 제목을</strong>을 입력하세요.';
	}


	$proc_memo = '';
	if (isset($_POST['proc_memo'])) {
		$proc_memo = substr(trim($_POST['proc_memo']),0,65536);
		$proc_memo = preg_replace("#[\\\]+$#", "", $proc_memo);
	}
	if ($proc_memo == '') {
		$msg[] = '<strong>내용</strong>을 입력하세요.';
	}



	$html = 'html1';

	$is_id = $_POST['is_id'];
	$pj_id = $_POST['pj_id'];
	$is_status = $_POST['is_status'];
	$is_proc_precent = $_POST['is_proc_precent'];



	if($oper=='add'){

if($_POST['mb_id']){

	$row = sql_fetch("select mb_name from psj_member where mb_id = '$_POST[mb_id]'");

	$MB = " mb_id = '$_POST[mb_id]',
	     wr_name = '$row[mb_name]',";

}else{
	$MB = " mb_id = '$member[mb_id]',
	     wr_name = '$member[mb_name]',";
}

	$query ="insert into psj_issu set
			
			is_option = '$html',
			is_subject = '$is_subject',
			is_content = '$is_content',
			pj_id = '$pj_id',
			is_status = '$is_status',
			is_proc_percent = '0',
			$MB
			sdate = '$sdate',
			edate = '$edate',
			is_datetime = Now()";
		sql_query($query);


	   $is_id = sql_insert_id();

	}
	
	
	
	if($oper=='edit'){

	if($is_id){



if($_POST['mb_id']){

		$row = sql_fetch("select mb_name from psj_member where mb_id = '$_POST[mb_id]'");

		$MB = " mb_id = '$_POST[mb_id]',
		     wr_name = '$row[mb_name]',";

	}else{
		$MB = " mb_id = '$member[mb_id]',
		     wr_name = '$member[mb_name]',";
	}



	$query ="update psj_issu set

			is_subject = '$is_subject',
			is_content = '$is_content',
			pj_id = '$pj_id',
			is_status = '$is_status',
			is_proc_percent = '$is_proc_precent',
			sdate = '$sdate',
			edate = '$edate',
			$MB
			is_datetime = Now()
			where is_id = '$is_id'";
		sql_query($query);

//echo $query;exit;



	if($is_ori_precent < $is_proc_precent){

	$query2 ="insert into psj_issu_log set
			
			is_id = '$is_id',
			percent = '$is_proc_precent',
			status = '$is_status',
			content = '$proc_memo',
			mb_id = '$mb_id',
			regdate = Now()";
		sql_query($query2);


	   }


	}


}



	if($_POST['memo_oper']=='add'){



	$query2 ="insert into psj_issu_log set
			
			is_id = '$is_id',
			percent = '$is_proc_precent',
			status = '$is_status',
			subject = '$co_subject',
			content = '$proc_memo',
			regdate = Now()";
		sql_query($query2);


	$query2 ="update psj_issu set

			is_proc_percent = '$is_proc_precent'
			where is_id = '$is_id'";
		sql_query($query2);


		goto_url("./issu_view.php?is_id=$is_id&part=issu");

	}




// 본문삭제
	if($oper=='del'){


		$file_path = '/home/mta/www';

		 $res = sql_query("select bf_file,seq  from psj_board_file where bo_table = 'issu' and wr_id='$is_id'");

		 while($row = sql_fetch_array($res)){

		    @unlink($file_path.'/data/pms/issu/'.$row['bf_file']);

		$sql = "delete from psj_board_file where seq='$row[seq]'";

		$result = sql_query( $sql );
		
		}


	$query ="delete from psj_issu

			where is_id = '$is_id'";
	
		sql_query($query);

		goto_url("./issu_list.php?part=issu");
	}



// 로그삭제
	if($_POST['oper2']=='logdel'){


	$query ="delete from psj_issu_log

			where is_id = '$_POST[is_id]'";
	
		sql_query($query);


		goto_url("./issu_view.php?is_id=$is_id&part=issu");
	}




		goto_url("./issu_view.php?is_id=$is_id&part=issu");








?>