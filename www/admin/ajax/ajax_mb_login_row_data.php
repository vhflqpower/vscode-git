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
	$rowcnt = sql_query("SELECT count(*) as cnt from psj_login where mb_id = '$mb_id' ".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);
	$sql = "select lo_ip,lo_datetime from psj_login where mb_id = '$mb_id' ".$WHERE."  ORDER BY lo_datetime DESC";


	$paginationlink = "/admin/ajax/ajax_mb_login_row_data.php?bo_table=$bo_table&page=";				
	$total_count =$cntsql['cnt'];

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
TOTAL: <span style='color:#ff0000;'><?=number_format($total_count)?></span>
<table class="table table-striped">
						<col width="20%">
						<col width="20%">
						<col width="60%">
								  <thead>
									<tr>
									  <th>NO</th>
									  <th>IP</th>
									  <th>DATE TIME</th>
									</tr>
								  </thead>
						  <tbody >

							<?php
							$num = 1;
								$results = sql_query($query);
								while($row = sql_fetch_array($results))
								{
							 ?>
							 <tr>
								 <td ><?=$num?></td>
								 <td ><?=$row['lo_ip']?></a></td>
								 <td><?=$row['lo_datetime']?></td>
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

