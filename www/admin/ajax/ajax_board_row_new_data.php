<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
//	include_once("./_common.php");
	$item_per_page = 20;
//	include_once("./dbconfig.php");

	$search_field = $_POST["search_field"];
	$search_value = $_POST["search_value"];
	$co_id = $_POST["co_id"];


	if(isset($_POST["page"])){
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1;
	}


//$page_number = 1;
// $position, $item_per_page  


	$position = (($page_number-1) * $item_per_page);

	$arr_gubun =  select_gubun();

	$WHERE =" bo_table='info'";
	


		$sql = "SELECT * FROM psj_board  where  $WHERE ORDER BY wr_datetime DESC LIMIT $position, $item_per_page";
		$result = sql_query($sql);


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
			 <td ><!-- <div align=center> -->
			 
			 <? if($bo_table=='bugreport'){ ?>
			<?=$status?>
			<? }else{ ?>
			 <font color=blue><?=$gubun1?></font>
			 <? } ?>
			</a><!-- </div> -->
			 
			 
			 </td>
			 <td id=item_<?=$row['wr_id']?>><strong><a href="./board_view.php?wr_id=<?=$wr_id?>&part=<?=$part?>&bo_table=<?=$bo_table?>"><?=$wr_subject?></a></strong>
			<? if($com_cnt > 0){ ?><span class="badge"><?=$com_cnt?></span><? } ?>
			 <?=$list['icon_new']?>
			
			<? if($bo_table == 'bugreport'){ ?>
			 <?//=$arr_debug_gubun[$wr_2];?>
			 <? } ?>
			 </td>
			 <td ><?=$list['icon_confirm']?></td>
			 <td ><?=$row['wr_name']?></td>
			 <td ><a href="./board_write.php?wr_id=<?=$wr_id?>&part=<?=$part?>&bo_table=<?=$bo_table?>"><?=$wr_date?></a></td>
			 <td><?=$row['wr_hit']?></td>
		 </tr>

<?

	//if(count($row['mi_id']) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
$num++;
	}

				
?>

