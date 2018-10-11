<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	require_once("./pagination.class.php");

	$perPage = new PerPage();


	$search_value = $_GET['search_value'];
	$cat1 = $_GET['cat1'];


	//print_r($_GET);


	$WHERE = "";

	if($_GET['search_value']){ 
		$WHERE .= " and wr_subject LIKE '%$search_value%'"; 
		}


	if($_GET['cat1']){ 
		$WHERE .= " and wr_cat1 = '$cat1'"; 
		}


	$page = $_GET['page'];

	$rowcnt = sql_query("SELECT count(*) as cnt from psj_board  where 1=1 and bo_table='info' ".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);

	$sql = "SELECT * from psj_board where 1=1 and bo_table='info' ".$WHERE." ORDER BY wr_id DESC";

	$paginationlink = "/admin/ajax/ajax_board_row_data.php?page=";				



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

	$perpageresult = $perPage->perpage($total_page, $paginationlink);
?>

	<table class="table table-striped">
	<col width="10%">
	<col width="10%">
	<col width="50%">
	<col width="10%">
	<col width="10%">
	<col width="10%">
              <thead>
                <tr>
                  <th>NO[<?=$total_count?>]</th>
                  <th>분류</th>
                  <th>제목</th>
                  <th>작성자</th>
                  <th>작성일</th>
                  <th>조회</th>
                </tr>
              </thead>
	  <tbody >
<?
/*
	$results = sql_query("SELECT a.*,(select c.codename from psj_code c where a.wr_cat1= c.code && c.pcode='100000') as ca_name FROM psj_board a where ".$where." ORDER BY a.wr_id DESC LIMIT $position, $item_per_page");
	while($row = sql_fetch_array($results))
	{
*/
		while($row=sql_fetch_array($result)){


		$wr_id = $row['wr_id'];
		$c1 = $row['wr_cat1'];
		$c2 = $row['wr_cat2'];
		$wr_subject = $row['wr_subject'];

		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);

		 $arr_info_gubun =  select_info_gubun($c1);

		$company = $arr_company[$mb_1];
		$gubun1 = $arr_info_gubun[$c2];


?>
	
		 <tr>
			 <td><?=$wr_id?></td>
			 <td ><!-- <div align=center> --><font color=blue><?=$gubun1?></a><!-- </div> --></td>
			 <td id=item_<?=$row['wr_id']?>><strong><a href="./board_view.php?wr_id=<?=$wr_id?>&part=info"><?=$wr_subject?></a></strong></td>
			 <td ><?=$row['wr_name']?></td>
			 <td ><a href="./board_write.php?wr_id=<?=$wr_id?>&part=info"><?=$row['wr_datetime']?></a></td>
			 <td><?=$row['wr_hit']?></td>
		 </tr>
		
<?

		if(count($row) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
}
		echo " </tbody></table>";

echo "<button type='button' class='btn btn-primary btn-sm' onclick=\"location.href='./board_write.php?part=info'\">
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

