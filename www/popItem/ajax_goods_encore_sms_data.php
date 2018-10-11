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

	$gd_no = $_GET['gd_no'];

	$sended = $_GET['sended'];


	$WHERE  ="";


	if($sended==1){
	$WHERE .="AND a.send_datetime = '0000-00-00 00:00:00'";
	}else if($sended==2){
	$WHERE .="AND a.send_datetime > '0000-00-00 00:00:00'";
	}


	if($gd_no){
	$WHERE .="AND a.gd_id = '$gd_no'";
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

	$result = sql_query("SELECT COUNT(*) AS count FROM tt_goods_encore a where 1=1 $WHERE");
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
		
	$sql = "SELECT a.en_id,a.gd_id,a.mb_id,b.mb_hp,a.send_datetime from tt_goods_encore a, tt_member b where  a.mb_id = b.mb_id  $WHERE  ORDER BY  a.en_id asc, $sidx $sord LIMIT $start , $limit";
	$result = sql_query( $sql );


	@$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['en_id'];
		$responce->rows[$i]['cell']=array($row['en_id'],$row['gd_id'],$row['mb_id'],$row['mb_hp'],$row['send_datetime']);
		$i++;
	}       
	echo json_encode($responce);



?>
