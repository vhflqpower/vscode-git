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


	$ta_id = $_GET['ta_id'];


	$WHERE  ="";

	if($ta_id){
	$WHERE .="AND ta_id = '$ta_id'";
	}


	if($sdate && $edate){
	$WHERE .= "AND  mo_date BETWEEN '$sdate' AND '$edate'";
	}

	if($search_field && $search_value){
	$WHERE .= "AND $search_field LIKE '%$search_value%'";
	}


	if($ta_id){

	$result = sql_query("SELECT COUNT(*) AS count FROM tt_tag_cell  where 1=1 $WHERE");
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
		
	$sql = "SELECT tc_no,seq,tc_id,ti_id,ta_id,mb_id from tt_tag_cell where 1=1  $WHERE  ORDER BY tc_no asc, $sidx $sord LIMIT $start , $limit";
	$result = sql_query( $sql );


	@$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['tc_no'];
		$responce->rows[$i]['cell']=array($row['tc_no'],$row['seq'],$row['tc_id'],$row['ti_id'],$row['ta_id'],$row['mb_id']);
		$i++;
	}     
	
}
	echo json_encode($responce);



?>
