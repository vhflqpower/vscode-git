<?php
	include_once("_common.php");


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


	$WHERE  ="";

	if($cat1){
	$WHERE .="AND mo_part = '$cat1'";
	}


	if($search_date){
	$WHERE .= "AND  mo_date BETWEEN '$search_date' AND '$search_date'";
	}

	if($sdate && $edate){
	$WHERE .= "AND  mo_date BETWEEN '$sdate' AND '$edate'";
	}

	if($search_field && $search_value){
	$WHERE .= "AND $search_field LIKE '%$search_value%'";
	}

	$result = sql_query("SELECT COUNT(*) AS count FROM psj_member a  where 1=1 $WHERE");
	$row = sql_fetch_array($result);
	$count = $row['count'];


	$limit = $limit;
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		
	$sql = "SELECT a.mb_no,a.mb_name,a.mb_hp,a.mb_email,a.mb_1,
			(select b.co_name from psj_company b where b.co_id = a.mb_1)as company
			from psj_member a where 1=1  $WHERE  ORDER BY a.mb_no asc, $sidx $sord LIMIT $start , $limit";
	$result = sql_query( $sql );

	

	@$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['mb_no'];
		$responce->rows[$i]['cell']=array($row['mb_no'],$row['mb_1'],$row['mb_name'],$row['mb_hp'],$row['mb_email'],$row['company']);
		$i++;
	}       
	echo json_encode($responce);



?>
