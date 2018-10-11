<?
	include_once("./_common.php");

	$wr_id = $_GET['wr_id'];
	$g5['board_table'] ='psj_board_config';


	if($bo_table=='schedule'){
		$write_table = 'psj_board_schedule';
	}else{
		$write_table = 'psj_board';
	}


	$g5['board_file_table'] ='psj_board_file';

	if($wr_id){
		$test_sql = "SELECT * FROM $write_table WHERE  wr_id = '$wr_id'";
		$view = sql_fetch("SELECT * FROM $write_table WHERE  wr_id = '$wr_id'");

	$html = 'html1';

	$content = $view['wr_content'] ;



    if ($member[mb_level] < 2)
    {
        if ($member[mb_id])
            alert("글을 읽을 권한이 없습니다.", $g4[path]);
        else
            alert("접근 권한이 없습니다.\\n\\회원이시라면 관리자에게 문의해 보십시오.", "/member/login.php?wr_id=$wr_id{$qstr}&url=".urlencode("/board/view.php?bo_table=$bo_table"));
    }




    if ($html)
    {
        $source = array();
        $target = array();

        $source[] = "//";
        $target[] = "";

        if ($html == 2) { // 자동 줄바꿈
            $source[] = "/\n/";
            $target[] = "<br/>";
        }

        // 테이블 태그의 개수를 세어 테이블이 깨지지 않도록 한다.
        $table_begin_count = substr_count(strtolower($content), "<table");
        $table_end_count = substr_count(strtolower($content), "</table");
        for ($i=$table_end_count; $i<$table_begin_count; $i++)
        {
            $content .= "</table>";
        }

        $content = preg_replace($source, $target, $content);

        if($filter)
            $content = html_purifier($content);
    }

	$view['contents'] =$content; 
	

/*
	$html = 0;
	if (strstr($view['wr_option'], 'html1'))
		$html = 1;
	else if (strstr($view['wr_option'], 'html2'))
		$html = 2;
*/


	

	//$view['content'] = conv_content($view['wr_content'], $html);




	}


	//print_r($view);

		$row_board = sql_fetch("select bo_subject from psj_board_config where bo_table = '$bo_table'");

// 코멘트
		$sql = " select * from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 order by wr_comment, wr_comment_reply ";
		$result = sql_query($sql);
		for ($i=0; $row=sql_fetch_array($result); $i++)
		{

		            $list[$i]['comment'] =  $row['wr_comment'];

		}

// 첨부파일


		$view['file']['count'] = 0;
		$sql = " select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
		$result = sql_query($sql);

		while ($row = sql_fetch_array($result))
		{
			$no = $row['bf_no'];
			$view['file'][$no]['href'] = "/board/download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$no" . $qstr;
			$view['file'][$no]['download'] = $row['bf_download'];
			// 4.00.11 - 파일 path 추가
			$view['file'][$no]['path'] = G5_DATA_URL.'/file/'.$bo_table;
			$view['file'][$no]['size'] = get_filesize($row['bf_filesize']);
			$view['file'][$no]['datetime'] = $row['bf_datetime'];
			$view['file'][$no]['source'] = addslashes($row['bf_source']);
			$view['file'][$no]['bf_content'] = $row['bf_content'];
			$view['file'][$no]['content'] = get_text($row['bf_content']);
			$view['file'][$no]['view'] = view_file_link($row['bf_file'], $row['bf_width'], $row['bf_height'], $view['file'][$no]['content']);
			$view['file'][$no]['file'] = $row['bf_file'];
			$view['file'][$no]['image_width'] = $row['bf_width'] ? $row['bf_width'] : 640;
			$view['file'][$no]['image_height'] = $row['bf_height'] ? $row['bf_height'] : 480;
			$view['file'][$no]['image_type'] = $row['bf_type'];
			$view['file']['count']++;
		}


    // 한번 읽은글은 브라우저를 닫기전까지는 카운트를 증가시키지 않음
    $ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
    if (!get_session($ss_name))
    {
        sql_query(" update {$write_table} set wr_hit = wr_hit + 1 where wr_id = '{$wr_id}' ");

        // 자신의 글이면 통과
        if ($write['mb_id'] && $write['mb_id'] == $member['mb_id']) {
            ;
        } else if ($is_guest && $board['bo_read_level'] == 1 && $write['wr_ip'] == $_SERVER['REMOTE_ADDR']) {
            // 비회원이면서 읽기레벨이 1이고 등록된 아이피가 같다면 자신의 글이므로 통과
            ;
        } else {
            // 글읽기 포인트가 설정되어 있다면
         
			/*
			
			if ($config['cf_use_point'] && $board['bo_read_point'] && $member['mb_point'] + $board['bo_read_point'] < 0)
                alert('보유하신 포인트('.number_format($member['mb_point']).')가 없거나 모자라서 글읽기('.number_format($board['bo_read_point']).')가 불가합니다.\\n\\n포인트를 모으신 후 다시 글읽기 해 주십시오.');

            insert_point($member['mb_id'], $board['bo_read_point'], ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']).' '.$wr_id.' 글읽기', $bo_table, $wr_id, '읽기');
			*/
		
		}

        set_session($ss_name, TRUE);
    }


	include_once(G5_PATH."/theme/offcanvas/head.php");

	include_once(G5_PATH."/skin/$board[bo_skin]/view.skin.php");

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
					$sql_bo = sql_query("SELECT * FROM `psj_board_config` WHERE bo_use_yn ='Y' ORDER BY bo_sort DESC");
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



	<!-- side-bar
	include_once("$app[path]/include/side_navi_board_bar.php");  -->


<?

	include_once(G5_PATH."/theme/offcanvas/tail.php");

?>