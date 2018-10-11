<?
$app_path = ".."; // common.php 의 상대 경로
include_once("../common.php");


		if($bo_table=='schedule'){
			$write_table = 'psj_board_schedule';
		}else{
			$write_table = 'psj_board';
		}

	$file_path = "..";

	$g5['board_file_table'] = 'psj_board_file';
	$g5['board_table'] ='psj_board_config';
	

	$notice_array = explode("\n", trim($board[bo_notice]));


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



	if (get_magic_quotes_gpc()) {
	    $wr_content = stripslashes($_POST['wr_content']);
	}
	else {
	    $wr_content = $_POST['wr_content'];
	}



	$wr_source = '';
	if (isset($_POST['wr_source'])) {
		$wr_source = substr(trim($_POST['wr_source']),0,65536);
	}



	if ($w == 'u' || $w == 'r') {
		$wr = get_write($write_table, $wr_id);
		if (!$wr['wr_id']) {
			alert("글이 존재하지 않습니다.\\n글이 삭제되었거나 이동하였을 수 있습니다.");
		}
	}



if ($w == '' || $w == 'u') {

/*
    // 김선용 1.00 : 글쓰기 권한과 수정은 별도로 처리되어야 함
    if($w =='u' && $member['mb_id'] && $wr['mb_id'] == $member['mb_id']) {
        ;
    } else if ($member['mb_level'] < $board['bo_write_level']) {
        alert('글을 쓸 권한이 없습니다.');
    }

	// 외부에서 글을 등록할 수 있는 버그가 존재하므로 공지는 관리자만 등록이 가능해야 함
	if (!$is_admin && $notice) {
		alert('관리자만 공지할 수 있습니다.');
    }
*/


} else if ($w == 'r') {

    if (in_array((int)$wr_id, $notice_array)) {
        alert('공지에는 답변 할 수 없습니다.');
    }

/*
    if ($member['mb_level'] < $board['bo_reply_level']) {
        alert('글을 답변할 권한이 없습니다.');
    }
*/

    // 게시글 배열 참조
    $reply_array = &$wr;

    // 최대 답변은 테이블에 잡아놓은 wr_reply 사이즈만큼만 가능합니다.
    if (strlen($reply_array['wr_reply']) == 10) {
        alert("더 이상 답변하실 수 없습니다.\\n답변은 10단계 까지만 가능합니다.");
    }

    $reply_len = strlen($reply_array['wr_reply']) + 1;
    if ($board['bo_reply_order']) {
        $begin_reply_char = 'A';
        $end_reply_char = 'Z';
        $reply_number = +1;
        $sql = " select MAX(SUBSTRING(wr_reply, $reply_len, 1)) as reply from {$write_table} where wr_num = '{$reply_array['wr_num']}' and SUBSTRING(wr_reply, {$reply_len}, 1) <> '' ";
    } else {
        $begin_reply_char = 'Z';
        $end_reply_char = 'A';
        $reply_number = -1;
        $sql = " select MIN(SUBSTRING(wr_reply, {$reply_len}, 1)) as reply from {$write_table} where wr_num = '{$reply_array['wr_num']}' and SUBSTRING(wr_reply, {$reply_len}, 1) <> '' ";
    }
    if ($reply_array['wr_reply']) $sql .= " and wr_reply like '{$reply_array['wr_reply']}%' ";
    $row = sql_fetch($sql);

    if (!$row['reply']) {
        $reply_char = $begin_reply_char;
    } else if ($row['reply'] == $end_reply_char) { // A~Z은 26 입니다.
        alert("더 이상 답변하실 수 없습니다.\\n답변은 26개 까지만 가능합니다.");
    } else {
        $reply_char = chr(ord($row['reply']) + $reply_number);
    }

    $reply = $reply_array['wr_reply'] . $reply_char;


} else {
    alert('w 값이 제대로 넘어오지 않았습니다.');
}

/*
if ($is_guest && !chk_captcha()) {
    alert('자동등록방지 숫자가 틀렸습니다.');
}
*/



    if ($w == 'r') {
        // 답변의 원글이 비밀글이라면 비밀번호는 원글과 동일하게 넣는다.
        if ($secret)
            $wr_password = $wr['wr_password'];

        $wr_id = $wr_id . $reply;
        $wr_num = $write['wr_num'];
        $wr_reply = $reply;
    } else {
        $wr_num = get_next_num($write_table);
        $wr_reply = '';
    }



	if($w=='' || $w == "r"){




		if ($member['mb_id']){
			$board['bo_use_name'] = 1;
			$mb_id = $member['mb_id'];
			$wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
			$wr_password = $member['mb_password'];
		//	$wr_email = addslashes($member['mb_email']);
		//	$wr_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
		} else {
			$mb_id = '';
			
			// 비회원의 경우 이름이 누락되는 경우가 있음
			$wr_name = clean_xss_tags(trim($_POST['wr_name']));
			if (!$wr_name)
				alert('이름은 필히 입력하셔야 합니다.');
		
			$wr_password = get_encrypt_string($wr_password);
			$wr_email = get_email_address(trim($_POST['wr_email']));
			$wr_homepage = clean_xss_tags($wr_homepage);
		}






/*
		if ($member['mb_id']){
			$mb_id = $member['mb_id'];
			$wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
			$wr_password = $member['mb_password'];
			$wr_email = addslashes($member['mb_email']);
			$wr_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
		} else {
			$mb_id = '';
			
			// 비회원의 경우 이름이 누락되는 경우가 있음
			$wr_name = clean_xss_tags(trim($_POST['wr_name']));
			if (!$wr_name)
				alert('이름은 필히 입력하셔야 합니다.');
		
			$wr_password = get_encrypt_string($wr_password);
			$wr_email = get_email_address(trim($_POST['wr_email']));
			$wr_homepage = clean_xss_tags($wr_homepage);
		}
*/


    if ($w == 'r') {
        // 답변의 원글이 비밀글이라면 비밀번호는 원글과 동일하게 넣는다.
        if ($secret)
            $wr_password = $wr['wr_password'];

        $wr_id = $wr_id . $reply;
        $wr_num = $write['wr_num'];
        $wr_reply = $reply;
    } else {
      
	  	$wr_num = get_next_num('psj_board');
	  //  $wr_num = get_next_num($write_table);
        $wr_reply = '';
    }


// ca_name
// 			wr_no = '$wr_no',
		$wr_no = get_next_no('psj_board',$bo_table);

	$query ="insert into $write_table set
			wr_num = '$wr_num',
			wr_reply = '$wr_reply',
			wr_comment = 0,
			bo_table = '$bo_table',
			wr_cat1 ='$ca_name',
			wr_subject = '$wr_subject',
			wr_option = 'html1',
			wr_content = '$wr_content',
			wr_datetime = Now(),
			mb_id = '$mb_id',
			wr_name = '$wr_name',
			wr_link1  = '',
			wr_link2  = '',
			wr_link1_hit  = '0',
			wr_link2_hit  = '0',
			wr_trackback  = '0',
			wr_hit  = '0',
			wr_good  = '0',
			wr_nogood  = '0',
			wr_password  = '$wr_password',
			wr_email = '$wr_email',
			wr_homepage = '',
			wr_last = '',
			wr_ip = '{$_SERVER['REMOTE_ADDR']}',
			wr_source_type = '$wr_source_type',
			wr_source = '$wr_source',
			wr_1 = '$wr_1'
			";

		sql_query($query);
//echo $query;exit;

    $wr_id = sql_insert_id();

	$query2 ="update $write_table set
			wr_parent = '$wr_id'
			where wr_id = '$wr_id'";
		sql_query($query2);

    // 게시글 1 증가
    sql_query("update $write_table set bo_count_write = bo_count_write + 1 where bo_table = '$bo_table'");

        if ($is_notice)
        {
            $bo_notice = $wr_id . "\n" . $board['bo_notice'];
            sql_query(" update $write_table set bo_notice = '$bo_notice' where bo_table = '$bo_table' ");

		}


	}else if($w=='u'){


	$query2 ="update $write_table set
			wr_cat1 ='$ca_name',
			wr_subject = '$wr_subject',
			wr_name = '$wr_name',
			wr_password = '$wr_password',
			wr_email = '$wr_email',
			wr_content = '$wr_content',
			wr_source_type = '$wr_source_type',
			wr_source = '$wr_source',
			wr_1 = '$wr_1'
			where wr_id = '$wr_id'";

		sql_query($query2);

	//echo $query2;exit;

    if ($is_notice) 
    {
        if (!in_array((int)$wr_id, $notice_array))
        {
            $bo_notice = $wr_id . '\n' . $board[bo_notice];
            sql_query(" update $write_table set bo_notice = '$bo_notice' where bo_table = '$bo_table' ");
        }
    } 
    else 
    {
        $bo_notice = '';
        for ($i=0; $i<count($notice_array); $i++)
            if ((int)$wr_id != (int)$notice_array[$i])
                $bo_notice .= $notice_array[$i] . '\n';
        $bo_notice = trim($bo_notice);
        sql_query(" update psj_board_config set bo_notice = '$bo_notice' where bo_table = '$bo_table' ");
    }




	}else  if($w=='del'){

		// 첨부파일삭제
		$sql2 = " select * from psj_board_file where bo_table = '$bo_table' and wr_id = '$wr_id' ";
        $result2 = sql_query($sql2);
        while ($row2 = sql_fetch_array($result2)){
            @unlink("$file_path/data/file/$bo_table/$row2[bf_file]");
            
		}
		// 첨부이미지삭제
		$sql3 = " select * from psj_board_img where bo_table = '$bo_table' and wr_id = '$wr_id' ";
        $result3 = sql_query($sql3);
        while ($row3 = sql_fetch_array($result3)){
            @unlink("$file_path/data/ckeditor/$bo_table/$row3[bf_file]");
            
		}

        // 파일테이블 행 삭제
        sql_query(" delete from psj_board_file where bo_table = '$bo_table' and wr_id = '$wr_id'");
        sql_query(" delete from psj_board_img where bo_table = '$bo_table' and wr_id = '$wr_id'");

		$query2 ="delete from $write_table where wr_parent = '$wr_id'";
			sql_query($query2);


		goto_url("list.php?bo_table=$bo_table");


	}



	$upload_max_filesize = ini_get('upload_max_filesize');


	if (empty($_POST))
		alert("파일 또는 글내용의 크기가 서버에서 설정한 값을 넘어 오류가 발생하였습니다.\\n\\npost_max_size=".ini_get('post_max_size')." , upload_max_filesize=$upload_max_filesize\\n\\n게시판관리자 또는 서버관리자에게 문의 바랍니다.");

		# 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
		@mkdir("$file_path/data/board/file/$bo_table", 0707);
		@chmod("$file_path/data/board/file/$bo_table", 0707);


		$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

		# 가변 파일 업로드
		$file_upload_msg = "";
		$upload = array();



		for ($i=0; $i<count($_FILES[bf_file][name]); $i++) 
		{
			# 삭제에 체크가 되어있다면 파일을 삭제합니다.
			if ($_POST[bf_file_del][$i]) 
			{
				$upload[$i][del_check] = true;

				$row = sql_fetch(" select bf_file from `psj_board_file` where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
				@unlink("$file_path/data/board/file/$bo_table/$row[bf_file]");
			}
			else
				$upload[$i][del_check] = false;

			$tmp_file  = $_FILES[bf_file][tmp_name][$i];
			$filesize  = $_FILES[bf_file][size][$i];
			$filename  = $_FILES[bf_file][name][$i];
			$filename  = preg_replace('/(\s|\<|\>|\=|\(|\))/', '_', $filename);

		 
			
			# 서버에 설정된 값보다 큰파일을 업로드 한다면
			if ($filename)
			{
				if ($_FILES[bf_file][error][$i] == 1)
				{
					$file_upload_msg .= "\'{$filename}\' 파일의 용량이 서버에 설정($upload_max_filesize)된 값보다 크므로 업로드 할 수 없습니다.\\n";
					continue;
				}
				else if ($_FILES[bf_file][error][$i] != 0)
				{
					$file_upload_msg .= "\'{$filename}\' 파일이 정상적으로 업로드 되지 않았습니다.\\n";
					continue;
				}
			}



			if (is_uploaded_file($tmp_file)) 
			{
				# 관리자가 아니면서 설정한 업로드 사이즈보다 크다면 건너뜀
				if ( $filesize > $board[bo_upload_size])  // !$is_admin &&
				{
					$file_upload_msg .= "\'{$filename}\' 파일의 용량(".number_format($filesize)." 바이트)이 게시판에 설정(".number_format($board[bo_upload_size])." 바이트)된 값보다 크므로 업로드 하지 않습니다.\\n";
					continue;
				}


				$timg = @getimagesize($tmp_file);
				# image type
				if ( preg_match("/\.($config[cf_image_extension])$/i", $filename) ||
					 preg_match("/\.($config[cf_flash_extension])$/i", $filename) ) 
				{
					if ($timg[2] < 1 || $timg[2] > 16)
					{
						#$file_upload_msg .= "\'{$filename}\' 파일이 이미지나 플래시 파일이 아닙니다.\\n";
						continue;
					}
				}
				#=================================================================

				$upload[$i][image] = $timg;

				# 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
				if ($w == 'edit')
				{
					# 존재하는 파일이 있다면 삭제합니다.
					$row = sql_fetch(" select bf_file from `psj_board_file` where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
					@unlink("$file_path/data/board/file/$bo_table/$row[bf_file]");
				}


				# 프로그램 원래 파일명
				$upload[$i][source] = $filename;
				$upload[$i][filesize] = $filesize;

				# 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
				$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);


				shuffle($chars_array);
				$shuffle = implode("", $chars_array);

				$upload[$i][file] = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename))); 

				$dest_file = "$file_path/data/board/file/$bo_table/" . $upload[$i][file];

		
					//echo $dest_file;exit;

				//echo $dest_file;exit;


				# 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
				$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES[bf_file][error][$i]);
				# 올라간 파일의 퍼미션을 변경합니다.
				chmod($dest_file, 0606);


			}
		}






	//------------------------------------------------------------------------------
	// 가변 파일 업로드
	// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
	for ($i=0; $i<count($upload); $i++) 
	{
		$row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");


			if(!$upload[$i][image][0]) $upload[$i][image][0] =0;
			if(!$upload[$i][image][1]) $upload[$i][image][1] =0;
			if(!$upload[$i][image][2]) $upload[$i][image][2] =0;



		if ($row[cnt]) 
		{
			// 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
			// 그렇지 않다면 내용만 업데이트 합니다.
			if ($upload[$i][del_check] || $upload[$i][file]) 
			{
				$sql = " update {$g5['board_file_table']}
							set bf_source = '{$upload[$i][source]}',
								bf_file = '{$upload[$i][file]}',
								bf_content = '{$bf_content[$i]}',
								bf_filesize = '{$upload[$i][filesize]}',
								bf_width = '{$upload[$i][image][0]}',
								bf_height = '{$upload[$i][image][1]}',
								bf_type = '{$upload[$i][image][2]}',
								bf_datetime = Now()
						  where bo_table = '$bo_table'
							and wr_id = '$wr_id'
							and bf_no = '$i' ";
				sql_query($sql);


			} 
			else 
			{
				$sql = " update {$g5['board_file_table']}
							set bf_content = '{$bf_content[$i]}' 
						  where bo_table = '$bo_table'
							and wr_id = '$wr_id'
							and bf_no = '$i' ";
				sql_query($sql);


			}
		} 
		else 
		{



			$sql = " insert into {$g5['board_file_table']}
						set bo_table = '$bo_table',
							wr_id = '$wr_id',
							bf_no = '$i',
							bf_source = '{$upload[$i][source]}',
							bf_file = '{$upload[$i][file]}',
							bf_content = '{$bf_content[$i]}',
							bf_download = 0,
							bf_filesize = '{$upload[$i][filesize]}',
							bf_width = '{$upload[$i][image][0]}',
							bf_height = '{$upload[$i][image][1]}',
							bf_type = '{$upload[$i][image][2]}',
							bf_datetime = Now()";
			sql_query($sql);
	
		}
	}


	// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
	// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
	$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' ");
	for ($i=(int)$row[max_bf_no]; $i>=0; $i--) 
	{
		$row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
		// 정보가 있다면 빠집니다.
		if ($row2[bf_file]) break;

		// 그렇지 않다면 정보를 삭제합니다.
		sql_query(" delete from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");
	}

		// 파일의 개수를 게시물에 업데이트 한다.
		$row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
		sql_query(" update {$write_table} set wr_file = '{$row['cnt']}' where wr_id = '{$wr_id}' ");



		goto_url("view.php?bo_table=$bo_table&wr_id=$wr_id");




?>