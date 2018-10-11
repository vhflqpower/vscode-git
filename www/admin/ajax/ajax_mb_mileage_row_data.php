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
	$bo_table = $_GET['bo_table'];
	$part = $_GET['part'];

	$mb_id = $_GET['mb_id'];

	//print_r($_GET);


	$WHERE = " ";

	if($_GET['search_value']){ 
		$WHERE .= " and wr_subject LIKE '%$search_value%'"; 
		}


	$page = $_GET['page'];
	$rowcnt = sql_query("SELECT count(*) as cnt,sum(mi_point) as total_mileage from psj_mileage where mb_id = '$mb_id' ".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);
	$sql = "select mi_point,mi_memo,url,mi_regdate from psj_mileage where mb_id = '$mb_id' ".$WHERE."  ORDER BY mi_regdate DESC";


	$paginationlink = "/admin/ajax/ajax_mb_mileage_row_data.php?bo_table=$bo_table&page=";				
	$total_count =$cntsql['cnt'];
	$total_mileage =$cntsql['total_mileage'];

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

	$perpageresult = $perPage->perpage($total_page, $paginationlink);
?>
TOTAL: <span style='color:#ff0000;'><?=number_format($total_mileage)?></span>
<table class="table table-striped">
					<col width="20%">
					<col width="20%">
					<col width="40%">
					<col width="20%">
							  <thead>
								<tr>
								  <th>NO</th>
								  <th>마일리지</th>
								  <th>내역</th>
								  <th>DATETIME</th>
								</tr>
							  </thead>
					  <tbody >

						<?php
						$num = 1;
							while($row = sql_fetch_array($result))
							{
						 ?>
						 <tr>
							 <td ><?=$num?></td>
							 <td ><?=number_format($row['mi_point'])?></a></td>
							 <td>

								<?if($row['menu_cd']=='schedule_add'){ ?>
								<a href="<?=$row[url]?>"><?=$row['mi_memo']?></a>
								<? }else{ ?>
								<a href="/admin/<?=$row[url]?>"><?=$row['mi_memo']?></a>
								<? } ?>

							 
							 </td>
							 <td><?=$row['mi_regdate']?></td>
						 </tr>
					<?
					$num++;
						 } ?>

	<?
		if($total_count < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
		echo " </tbody></table>";

		echo "<button type='button' class='btn btn-primary btn-sm' onclick=\"location.href='./board_write.php?part=$part&bo_table=$bo_table'\">
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

