<?
	include_once("./_common.php");


//	$g5['board_file_table'] ='psj_board_file';


		$is_name     = false;
		$is_password = false;
		$is_email    = false;
	//	$is_homepage = false;
		if ($is_guest || ($is_admin && $w == 'u' && $member['mb_id'] != $write['mb_id'])) {
			$is_name = true;
			$is_password = true;
			$is_email = true;
			//$is_homepage = true;
		}


		if($bo_table=='schedule'){
			$write_table = 'psj_board_schedule';
		}else{
			$write_table = 'psj_board';
		}


		$write = sql_fetch("SELECT * FROM $write_table WHERE  wr_id = '$wr_id'");

		if($write['wr_id'] && $w=='r'){ 
			$w='r'; 
		}else if($write['wr_id']){
			$w='u';
		}else{
			$w='';
		}

		$notice_array = explode("\n", trim($board['bo_notice']));


	if (!($w == '' || $w == 'u' || $w == 'r')) {
		alert('w 값이 제대로 넘어오지 않았습니다.');
	}

		$is_file = true; // false;
	
		/*
		if ($member['mb_level'] >= $board['bo_upload_level']) {
			$is_file = true;
		}
		*/


/*
		$is_file_content = false;
		if ($board['bo_use_file_content']) {
			$is_file_content = true;
		}
*/
		$file_count = (int)$board['bo_upload_count'];


		$write['file']['count'] = 0;
		$sql = " select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
		$result = sql_query($sql);

		while ($row = sql_fetch_array($result))
		{
			$no = $row['bf_no'];
			$write['file'][$no]['href'] = G5_BBS_URL."/download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$no" . $qstr;
			$write['file'][$no]['download'] = $row['bf_download'];
			// 4.00.11 - 파일 path 추가
			$write['file'][$no]['path'] = G5_DATA_URL.'/file/'.$bo_table;
			$write['file'][$no]['size'] = get_filesize($row['bf_filesize']);
			$write['file'][$no]['datetime'] = $row['bf_datetime'];
			$write['file'][$no]['source'] = addslashes($row['bf_source']);
			$write['file'][$no]['bf_content'] = $row['bf_content'];
			$write['file'][$no]['content'] = get_text($row['bf_content']);
		
		//	$write['file'][$no]['write'] = write_file_link($row['bf_file'], $row['bf_width'], $row['bf_height'], //  $write['file'][$no]['content']);
			
			$write['file'][$no]['file'] = $row['bf_file'];
			$write['file'][$no]['image_width'] = $row['bf_width'] ? $row['bf_width'] : 640;
			$write['file'][$no]['image_height'] = $row['bf_height'] ? $row['bf_height'] : 480;
			$write['file'][$no]['image_type'] = $row['bf_type'];
			$write['file']['count']++;
		}



		$is_notice = false;
		if ( $w != "r")  // $is_admin 관리자
		{
			$is_notice = true;

			if ($w == "u")
			{
				// 답변 수정시 공지 체크 없음
				if ($write[wr_reply])
					$is_notice = false;
				else
				{
					$notice_checked = "";
					if (in_array((int)$wr_id, $notice_array))
						$notice_checked = "checked";
				}
			}
		}



	$is_dhtml_editor = false;
	$is_dhtml_editor_use = false;
	$editor_content_js = '';

	$content = get_text(html_purifier($write['wr_content']), 0);

	$editor_html = editor_html('wr_content', $content, $is_dhtml_editor);
	$editor_js = '';
	$editor_js .= get_editor_js('wr_content', $is_dhtml_editor);
	$editor_js .= chk_editor_js('wr_content', $is_dhtml_editor);

	
	include_once(G5_PATH."/theme/offcanvas/head.php");
	//include_once("/skin/$board[bo_skin]/write.skin.php");
	include_once(G5_PATH."/skin/$board[bo_skin]/write.skin.php");

?>

			<?	if($bo_table=='elern'){  ?>

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">

			<?
				$sql_bo = sql_query("SELECT wr_id,bo_table,wr_cat1,wr_subject FROM `psj_board` WHERE bo_table = 'elern'");

				while($row_bo = sql_fetch_array($sql_bo)){

					if(!$_GET['bo_table'])$bo_table='data_room';else $bo_table=$_GET['bo_table'];

					if($wr_id == $row_bo['wr_id'])$active ='active';else $active='';
				?>
					<a href="<?=$app['path']?>/board/view.php?bo_table=<?=$row_bo['bo_table']?>&wr_cat1=<?=$row_bo['wr_cat1']?>&wr_id=<?=$row_bo['wr_id']?>" class="list-group-item <?=$active?>"><?=$row_bo['wr_subject']?></a>
			<?	
				}
			?>

          </div>
        </div><!--/.sidebar-offcanvas-->
      
	  <? }else if($bo_table=='schedule' || $bo_table=='notice'){ ?>


        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
			<?
					$sql_bo = sql_query("SELECT * FROM `psj_board_config` WHERE 1 ORDER BY bo_sort DESC");
					while($row_bo = sql_fetch_array($sql_bo)){

						if(!$_GET['bo_table'])$bo_table='data_room';else $bo_table=$_GET['bo_table'];

						if($bo_table == $row_bo['bo_table'])$active ='active';else $active='';

			?>

            <a href="<?=$app['path']?>/board/list.php?bo_table=<?=$row_bo['bo_table']?>" class="list-group-item <?=$active?>"><?=$row_bo['bo_subject']?></a>

	<? } ?>

          </div>
        </div><!--/.sidebar-offcanvas-->




	  <? } ?>






	  </div><!--/row-->


<?
	//	include_once("$app[path]/include/side_navi_board_bar.php"); 
		include_once(G5_PATH."/theme/offcanvas/tail.php");

?>

