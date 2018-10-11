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

	$result = sql_query("SELECT COUNT(*) AS count FROM tt_tag  where 1=1 $WHERE");
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
		

	$res = sql_query("SELECT code,codename FROM `tt_code` WHERE pa_group = 'tag_type'");
	  while($rowi = sql_fetch_array($res)){
			
			$cd = $rowi['code'];
			$arr_type[$cd] = $rowi['codename']; 
	  }



	$sql = "SELECT a.ta_no,a.ta_type_code,a.ta_id,a.ta_price,a.ta_buy_price,
			(SELECT count(*) FROM tt_tag_item b WHERE b.ta_id = a.ta_id) as cnt,
			(SELECT count(*) FROM tt_tag_cell c WHERE c.ta_id = a.ta_id) as cnt2
			from tt_tag a where 1=1  $WHERE  ORDER BY a.ta_no asc, $sidx $sord LIMIT $start , $limit";
	$result = sql_query( $sql );


	@$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['ta_no'];

		$cd = $row['ta_type_code'];
		$TAGTYPE = $arr_type[$cd];

		$responce->rows[$i]['cell']=array($row['ta_no'],$TAGTYPE,$row['ta_id'],$row['cnt'],$row['cnt2'],$row['ta_price'],$row['ta_buy_price']);
		$i++;
	}       
	echo json_encode($responce);



?>
