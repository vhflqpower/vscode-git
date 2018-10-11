<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	require_once("./pagination.class.php");

	$perPage = new PerPage();


	$search_value = $_GET['search_value'];
	$cat1 = $_GET['cat1'];
	$cat2 = $_GET['cat2'];
	$bo_table = 'bugreport';// $_GET['bo_table'];
	$part = $_GET['part'];
	


	$WHERE = "";

	if($_GET['search_value']){ 
		$WHERE .= " and wr_subject LIKE '%$search_value%'"; 
		}

	if($_GET['cat1']){ 
		$WHERE .= " and wr_cat1 = '$cat1'"; 
		}


	if($_GET['cat2']){ 
		$WHERE .= " and wr_cat2 = '$cat2'"; 
		}



	if($part=='myreport'){ 
		$WHERE .= " and mb_id = '$member[mb_id]' and wr_open_yn = 'Y'"; 
		}


	$list = array();
	$i = 0;
		if (!$_GET['search_value'])
		{


			$arr_notice = explode("\n", trim($board[bo_notice]));
			for ($k=0; $k<count($arr_notice); $k++)
			{
				if (trim($arr_notice[$k])=='') continue;
				$row = sql_fetch(" select * from psj_board where wr_id = '$arr_notice[$k]' ");
				if (!$row[wr_id]) continue;

				$c1 = $row['wr_cat1'];
				$c2 = $row['wr_cat2'];
				$wr_1 = $row['wr_1'];
				$date = $row['wr_datetime'];
				$wr_date = short_date($date);

				$str = nl2br($row['wr_content']);
				$com_cnt = comment_count($bo_table,$wr_id); // 코멘트 카운트
				 $arr_info_gubun =  select_info_gubun($c1);
				$cate_name = $arr_info_gubun[$c2][0];
				$status = $arr_status[$wr_1];

				 $list[$i][gubun] = '<font color=red>'.$status.'</font>'; 	
				 $list[$i][wr_id] = $row['wr_id']; 				
				 $list[$i][mb_id] = $row['mb_id']; 
				 $list[$i][subject] = $row['wr_subject']; 
				 $list[$i][wr_no] = $row['wr_no']; 
				 $list[$i][is_notice] = true;
				 $list[$i][name] = $row['wr_name']; 
				 $list[$i][datetime2]  =$wr_date ; 
				 $list[$i][wr_hit]   = $row['wr_hit']; 
				$i++;
			}
		}


	$page = $_GET['page'];
	$rowcnt = sql_query("SELECT count(*) as cnt from psj_board  where  bo_table='$bo_table' ".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);

	$sql = "SELECT * from psj_board where  bo_table='$bo_table' ".$WHERE." ORDER BY wr_id DESC";
	$paginationlink = "/admin/ajax/ajax_my_openinfo_row_data.php?bo_table=$bo_table&page=";				
	$total_count =$cntsql[cnt];



	$rows = 20;
	if (!$page) $page = 1;
	$total_page  = ceil($total_count / $rows);  
	$start = ($page - 1) * $rows;


	if($start < 0) $start = 0;

	$query =  $sql . " limit " . $start . "," . $rows;


	$result = sql_query($query);

	if(empty($_GET["rowcount"])) {

	}


		//echo $query;

	$perpageresult = $perPage->perpage2($total_page, $paginationlink);
?>

	<table class="table table-striped">
				<col width="10%">
		 	 <? if($part =='myopeninfo'){ ?>
				<col width="10%">
				<? } ?>
				<col width="40%">
				<col width="9%">
				<col width="8%">
				<col width="8%">
				<col width="5%">
              <thead>
                <tr>
                  <th>NO[<?=$total_count?>]</th>
				<? if($part =='myopeninfo'){ ?>
                  <th>분류</th>
				<? } ?>
                  <th>제목</th>
				<? if($part =='myopeninfo'){ ?>
                  <th>구분</th>
				<? } ?>
                  <th>작성자</th>
                  <th>작성일</th>
                  <th>조회</th>
                </tr>
              </thead>
	  <tbody >
<!-- 
        <?php
        for ($i=0; $i<count($list); $i++) {
         ?>
		 <tr>
			 <td><font color=blue><?=$row['wr_id']?></font></td>
			 <? if($part =='myopeninfo'){ ?>			 
			 <td >공지</td>
			 <? } ?>
			 <td id=item_<?=$row['wr_id']?>><strong><a href="./board_view.php?wr_id=<?=$list[$i]['wr_id']?>&part=<?=$part?>&bo_table=<?=$bo_table?>"><?php echo $list[$i]['subject'] ?></a></strong>
			<? if($com_cnt > 0){ ?><span class="badge"><?=$com_cnt?></span><? } ?>
			 <?=$list['icon_new']?>
			 </td>
			  <? if($part =='myopeninfo'){ ?>
			 <td ><span class="label label-info">공지</span></td>
			 	 <? } ?>
			 <td ><?=$row['wr_name']?></td>
			 <td ><a href="./board_write.php?wr_id=<?=$wr_id?>&part=<?=$part?>&bo_table=<?=$bo_table?>"><?=$list[$i]['datetime2']?></a></td>
			 <td><?=$row['wr_hit']?></td>
		 </tr>
	<? } ?>
 -->

<?

		$board['bo_new'] =72;
		 $list['icon_new'] = '';
		 $list['icon_confirm'] = '';

		while($row=sql_fetch_array($result)){

		# 새로운글 아이콘
		if ($board['bo_new'] && $row['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
	          $list['icon_new'] = '<span class="label label-danger">New</span>';//' <img src=http://g5.master36.com/skin/board/test/img/icon_new.gif alt=새글>';
		else
		 $list['icon_new'] = '';



		if($row['wr_status']=='N' || $row['wr_status']==''){
			
			$list['icon_confirm'] = '<span class="label label-info">등록중</span>';
		}else{
		
		 if($row['wr_confirm']=='Y'){
			$list['icon_confirm'] = '<span class="label label-primary">승인완료</span>';
		 }else if($row['wr_confirm']=='N'){

			$list['icon_confirm'] = '<span class="label label-primary">검토중</span>';

		 }else{

			$list['icon_confirm'] = '<span class="label label-info">등록완료</span>';
		 }
		}

		$wr_id = $row['wr_id'];
		$c1 = $row['wr_cat1'];
		$c2 = $row['wr_cat2'];
		$wr_1 = $row['wr_1'];
		$wr_2 = $row['wr_2'];
		$wr_subject = $row['wr_subject'];
		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);
		$com_cnt = comment_count($bo_table,$wr_id); // 코멘트 카운트
		 $arr_info_gubun =  select_info_gubun($c1);
		$company = $arr_company[$mb_1];
		$gubun1 = $arr_info_gubun[$c2][0];
		$status = $arr_status[$wr_1];
		$date = $row['wr_datetime'];

		$wr_date = short_date($date);

?>
	
		 <tr>
			 <td><?=$wr_id?></td>
			<? if($part =='myopeninfo'){ ?>		
			 <td >
			 <font color=blue><?=$gubun1?></font>
			<!-- </a></div> -->
			 </td>
			<? } ?>
			 <td id=item_<?=$row['wr_id']?>><strong><a href="./my_board_view.php?wr_id=<?=$wr_id?>&part=<?=$part?>&bo_table=<?=$bo_table?>&page=<?=$page?>"><?=$wr_subject?></a></strong>
			<? if($com_cnt > 0){ ?><span class="badge"><?=$com_cnt?></span><? } ?>
			 <?=$list['icon_new']?>
			
			<? if($bo_table == 'bugreport'){ ?>
			 <?//=$arr_debug_gubun[$wr_2];?>
			 <? } ?>
			 </td>
			<? if($part =='myopeninfo'){ ?>		
			 <td ><?=$list['icon_confirm']?></td>
			<? } ?>
			 <td ><?=$row['wr_name']?></td>
			 <td ><a href="./board_write.php?wr_id=<?=$wr_id?>&part=<?=$part?>&bo_table=<?=$bo_table?>"><?=$wr_date?></a></td>
			 <td><?=$row['wr_hit']?></td>
		 </tr>
		
<?
		
}
		if($total_count < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
		echo " </tbody></table>";

		echo "<button type='button' class='btn btn-primary btn-sm' onclick=\"location.href='./my_board_write.php?part=$part&bo_table=$bo_table'\">
				  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>등록하기
				</button>";


	
		if(!empty($perpageresult)) {
		$output .="<div align='center'>";
		$output .= "<nav>";
		$output .= $perpageresult;
		$output .= "</nav>";
		$output .= "</div>";
		}

print $output;
echo "<div style='height:70px;></div>";
?>

