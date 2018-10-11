<?
	include_once("./_common.php");
	include_once("./board_auth.php");

	if($bo_table=='schedule'){
		$write_table = 'psj_board_schedule';
	}else{
		$write_table = 'psj_board';
	}

	##print_r($board);
	# 인라인카테고리용
	$row_cate = sql_fetch("select bo_category_list from psj_board_config where bo_table = '$bo_table' limit 1");
	$cate_item = explode("|",$row_cate[bo_category_list]);

		$board[bo_page_rows] = 10;
	


		$sca = $_GET['ca_name'];

	if (!$sst) {
		if ($board['bo_sort_field']) {
			$sst = $board['bo_sort_field'];
		} else {
			$sst  = "wr_num, wr_reply";
			$sod = "";
		}
	} else {
		// 게시물 리스트의 정렬 대상 필드가 아니라면 공백으로 (nasca 님 09.06.16)
		// 리스트에서 다른 필드로 정렬을 하려면 아래의 코드에 해당 필드를 추가하세요.
		// $sst = preg_match("/^(wr_subject|wr_datetime|wr_hit|wr_good|wr_nogood)$/i", $sst) ? $sst : "";
		$sst = preg_match("/^(wr_datetime|wr_hit|wr_good|wr_nogood)$/i", $sst) ? $sst : "";
	}

	if(!$sst)
		$sst  = "wr_num, wr_reply";

	if ($sst) {
		$sql_order = " order by {$sst} {$sod} ";
	}


	$stx = trim($stx);
	if ($sca || $stx)
	{
		
		
	//	$sql_search = get_sql_search($sca, $sfl, $stx, $sop);

		if($sca)$sca =" and wr_cat1 ='$sca'";else $sca='';

		$sql_search	= "((INSTR(wr_subject, '".$stx."')) ) $sca";


		// 가장 작은 번호를 얻어서 변수에 저장 (하단의 페이징에서 사용)
		$sql = " select MIN(wr_num) as min_wr_num from $write_table ";
		$row = sql_fetch($sql);
		$min_spt = $row[min_wr_num];

		if (!$spt) $spt = $min_spt;


		$sql_search  .= " and (wr_num between '".$spt."' and '".($spt + 10000)."') ";

		// ((INSTR(wr_subject, '팝업')) ) and (wr_num between '-92' and '9908')

		$sql = " select distinct wr_parent from $write_table where  $sql_search ";
		$result = sql_query($sql);
		$total_count = mysqli_num_rows($result);


	}
	else
	{
		$sql_search = "";

		$sql = " select distinct wr_id from $write_table where  bo_table = 'elern'";
		$result = sql_query($sql);
		$total_count = mysqli_num_rows($result);
		//$total_count = $board[bo_count_write];

	}

	$total_page  = ceil($total_count / 10);  // 전체 페이지 계산
	if (!$page) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * 10; // $board[bo_page_rows] 시작 열을 구함


//	$write_table = 'psj_board';

	$list = array();
	$i = 0;

		if (!$sca && !$stx)
		{
			$arr_notice = explode("\n", trim($board[bo_notice]));
			for ($k=0; $k<count($arr_notice); $k++)
			{
				if (trim($arr_notice[$k])=='') continue;
				$row = sql_fetch(" select * from $write_table where wr_id = '$arr_notice[$k]' ");
				if (!$row[wr_id]) continue;

			//	$list[$i] = get_list($row, $board, $board_skin_path, $board[bo_subject_len]);
				 $list[$i][wr_id] = $row['wr_id']; 				
				 $list[$i][mb_id] = $row['mb_id']; 
				 $list[$i][subject] = $row['wr_subject']; 
				 $list[$i][wr_no] = $row['wr_no']; 
				 $list[$i][is_notice] = true;
				 $list[$i][name] = $row['wr_name']; 
				 $list[$i][datetime2]  = $row['wr_datetime']; 
				 $list[$i][wr_hit]   = $row['wr_hit']; 
				$i++;
			}
		}



		$sql_search .= " and bo_table = '$bo_table'";
		if ($sst){
			$sql_order = " order by $sst $sod ";
		}else{
			$sql_order = " order by wr_id desc, wr_no desc ";
		}

		if ($sca || $stx)
		{


			$sql_order = " order by wr_id desc ";
			$sql = " select distinct wr_parent from $write_table where  $sql_search $sql_order limit $from_record, 20 ";

		}
		else
		{

			$sql = " select * from $write_table where wr_is_comment = 0  and bo_table = '$bo_table' $sql_order limit $from_record,$board[bo_page_rows] "; // $board[bo_page_rows]

		}

		$result = sql_query($sql);


	echo $sql;

		$k = 0;


		$list = array();


		while ($row = sql_fetch_array($result))
		{


			
				if ($sca || $stx)   // 검색일 경우 wr_id만 얻었으므로 다시 한행을 얻는다
			    $row = sql_fetch(" select * from $write_table where wr_id = '$row[wr_parent]' ");

		  //  $list[$i] = get_list($row, $board, $board_skin_path, $board[bo_subject_len]);

			 $list[$i][mb_id] = $row['mb_id']; 
			 $list[$i][subject] = $row['wr_subject']; 
			 $list[$i][comment_cnt] = $row['wr_comment']; 
			 $list[$i][no] = $total_count - ($page - 1) * $board[bo_page_rows] - $k;
			 $reply= $row['wr_reply']; 
			 $list[$i][wr_id] = $row['wr_id']; 
			 $list[$i][wr_no] = $row['wr_no']; 
			 $list[$i][is_notice] = false;
			 $list[$i][name] = $row['wr_name']; 
			 $list[$i][datetime2]  = $row['wr_datetime']; 
			 $list[$i][wr_hit]   = $row['wr_hit']; 

			$list[$i][reply] = strlen($reply)*10;
			if ($list[$i][reply]){
				$list[$i][icon_reply] = '<img src="./skin/'.$board['bo_skin'].'/img/icon_reply.gif" style="margin-left:'.$list[$i][reply].'px;" alt="답변글">Re:';
			
			}
		
			//	if ($board['bo_use_list_file'] || ($list['wr_file'] && $subject_len == 255) /* view 인 경우 */) {
				//		$list['file'] = get_file($board['bo_table'], $list['wr_id']);
				//	} else {
						$list[$i]['file']['count'] = $row['wr_file'];
				//	}
					
					if ($list[$i]['file']['count']){
					  $list[$i]['icon_file'] = '<img src="./skin/'.$board['bo_skin'].'/img/icon_file.gif" alt="첨부파일">';

					}


					if (strstr($sfl, "subject"))
					$list[$i][subject] = search_font($stx, $list[$i][subject]);  
					$list[$i][is_notice] = false;
					$list[$i][num] = $total_count - ($page - 1) * $board[bo_page_rows] - $k;
					
			$i++;
			$k++;
		}


		//G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages']

		$config['cf_write_pages']= 10;
		

	//	$write_pages = get_paging($config['cf_write_pages'], $page, $total_page, './list.php?bo_table='.$bo_table.$qstr.'&amp;page=');


		$write_pages = get_paging_bootst($config['cf_write_pages'], $page, $total_page, './list.php?bo_table='.$bo_table.$qstr.'&amp;page=');

	include_once(G5_PATH."/theme/offcanvas/head.php");

	// 리스트 스킨

	include_once(G5_PATH."/skin/$board[bo_skin]/list.skin.php");
	// 사이드바 메뉴
	//include_once("../snb.php"); 
    ?>


        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
			<?
					$sql_bo = sql_query("SELECT * FROM `psj_board_config` WHERE 1");
					while($row_bo = sql_fetch_array($sql_bo)){

						if(!$_GET['bo_table'])$bo_table='data_room';else $bo_table=$_GET['bo_table'];

						if($bo_table == $row_bo['bo_table'])$active ='active';else $active='';

			?>

            <a href="<?=$app['path']?>/board/list.php?bo_table=<?=$row_bo['bo_table']?>" class="list-group-item <?=$active?>"><?=$row_bo['bo_subject']?></a>

				<? } ?>

          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->




	<? include_once(G5_PATH."/theme/offcanvas/tail.php"); ?>

