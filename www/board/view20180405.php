<?
	include_once("./_common.php");


	$g5['board_table'] ='psj_board_config';


	if($bo_table=='schedule'){
		$write_table = 'psj_board_schedule';
	}else{
		$write_table = 'psj_board';
	}


	$g5['board_file_table'] ='psj_board_file';

	if($wr_id){
		$view = sql_fetch("SELECT * FROM psj_board WHERE  wr_id = '$wr_id'");



	$html = 'html1';

	$content = $view['wr_content'] ;



    if ($html)
    {
        $source = array();
        $target = array();

        $source[] = "//";
        $target[] = "";

        if ($html == 2) { // �ڵ� �ٹٲ�
            $source[] = "/\n/";
            $target[] = "<br/>";
        }

        // ���̺� �±��� ������ ���� ���̺��� ������ �ʵ��� �Ѵ�.
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

// �ڸ�Ʈ
		$sql = " select * from $write_table where wr_parent = '$wr_id' and wr_is_comment = 1 order by wr_comment, wr_comment_reply ";
		$result = sql_query($sql);
		for ($i=0; $row=sql_fetch_array($result); $i++)
		{

		            $list[$i]['comment'] =  $row['wr_comment'];

		}

// ÷������


		$view['file']['count'] = 0;
		$sql = " select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
		$result = sql_query($sql);

		while ($row = sql_fetch_array($result))
		{
			$no = $row['bf_no'];
			$view['file'][$no]['href'] = "/board/download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$no" . $qstr;
			$view['file'][$no]['download'] = $row['bf_download'];
			// 4.00.11 - ���� path �߰�
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


    // �ѹ� �������� �������� �ݱ��������� ī��Ʈ�� ������Ű�� ����
    $ss_name = 'ss_view_'.$bo_table.'_'.$wr_id;
    if (!get_session($ss_name))
    {
        sql_query(" update {$write_table} set wr_hit = wr_hit + 1 where wr_id = '{$wr_id}' ");

        // �ڽ��� ���̸� ���
        if ($write['mb_id'] && $write['mb_id'] == $member['mb_id']) {
            ;
        } else if ($is_guest && $board['bo_read_level'] == 1 && $write['wr_ip'] == $_SERVER['REMOTE_ADDR']) {
            // ��ȸ���̸鼭 �бⷹ���� 1�̰� ��ϵ� �����ǰ� ���ٸ� �ڽ��� ���̹Ƿ� ���
            ;
        } else {
            // ���б� ����Ʈ�� �����Ǿ� �ִٸ�
         
			/*
			
			if ($config['cf_use_point'] && $board['bo_read_point'] && $member['mb_point'] + $board['bo_read_point'] < 0)
                alert('�����Ͻ� ����Ʈ('.number_format($member['mb_point']).')�� ���ų� ���ڶ� ���б�('.number_format($board['bo_read_point']).')�� �Ұ��մϴ�.\\n\\n����Ʈ�� ������ �� �ٽ� ���б� �� �ֽʽÿ�.');

            insert_point($member['mb_id'], $board['bo_read_point'], ((G5_IS_MOBILE && $board['bo_mobile_subject']) ? $board['bo_mobile_subject'] : $board['bo_subject']).' '.$wr_id.' ���б�', $bo_table, $wr_id, '�б�');
			*/
		
		}

        set_session($ss_name, TRUE);
    }


	include_once(G5_PATH."/theme/offcanvas/head.php");

	include_once(G5_PATH."/skin/$board[bo_skin]/view.skin.php");

    ?>

        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
          <div class="list-group">
			<?
				
				$sql_bo = sql_query("SELECT wr_id,bo_table,wr_cat1,wr_subject FROM `psj_board` WHERE bo_table = 'elern'");
				while($row_bo = sql_fetch_array($sql_bo)){

					if(!$_GET['bo_table'])$bo_table='data_room';else $bo_table=$_GET['bo_table'];

					if($wr_id == $row_bo['wr_id'])$active ='active';else $active='';
				?>
					<a href="<?=$app['path']?>/board/view.php?bo_table=<?=$row_bo['bo_table']?>&wr_cat1=<?=$row_bo['wr_cat1']?>&wr_id=<?=$row_bo['wr_id']?>" class="list-group-item <?=$active?>"><?=$row_bo['wr_subject']?></a>
			<? } ?>

          </div>
        </div><!--/.sidebar-offcanvas-->
      </div><!--/row-->



	<!-- side-bar
	include_once("$app[path]/include/side_navi_board_bar.php");  -->


<?

	include_once(G5_PATH."/theme/offcanvas/tail.php");

?>