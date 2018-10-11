<?php

include_once("../../common.php");

	$page = $_GET['page']; 
	$limit = $_GET['rows']; 
	$sidx = $_GET['sidx']; 
	$sord = $_GET['sord']; 
	$search_field = $_GET['search_field'];
	$search_value = $_GET['search_value'];
	if(!$sidx) $sidx =1;

	$search_date_field = $_GET['search_date_field'];
	$sdate = $_GET['sdate'];
	$edate = $_GET['edate'];
	$search_date = $_GET['search_date'];

	$co_id = $_GET['co_id'];
	$cat1 = $_GET['cat1'];

	if($cat1){
	$WHERE .="AND a.mo_part = '$cat1'";
	}



	if($search_date){
	$WHERE .= "AND  a.mo_date BETWEEN '$search_date' AND '$search_date'";
	}


	if($sdate && $edate){
	$WHERE .= "AND  a.mo_date BETWEEN '$sdate' AND '$edate'";
	}


	if($search_field && $search_value){
	$WHERE .= "AND a.$search_field LIKE '%$search_value%'";
	}



	$result = sql_query("SELECT COUNT(*) AS count FROM co_cashbook a where 1=1 $WHERE");
	$row = sql_fetch_array($result,MYSQL_ASSOC);
	$count = $row['count'];

	$limit = $limit;
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		
		$sql = "SELECT * from co_cashbook a where 1=1  $WHERE ORDER BY $sidx $sord LIMIT $start , $limit";

	$result = sql_query( $sql );

	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['ca_no'];
		$responce->rows[$i]['cell']=array($row['ca_no'],$row['ca_wdate'],$row['ca_part'],$row['ca_code1'],$row['ca_money'],$row['ca_memo'],$row['ca_regdate']);
		$i++;
	}       
	echo json_encode($responce);



?>
