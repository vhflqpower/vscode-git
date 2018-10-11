<?php
	include_once("_common.php");

	$ARR_STATUS = array( 'y' => '오픈', 'p' => '결제', 't' => '양도' , 'oc' => '오픈취소' , 'pc' => '결제취소'  );


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


	$gd_id = $_GET['gd_id'];


	$WHERE  ="";

	if($gd_id){
	$WHERE .=" AND c.gd_id = '$gd_id'";
	}


	if($sdate && $edate){
	$WHERE .= "AND  mo_date BETWEEN '$sdate' AND '$edate'";
	}

	if($search_field && $search_value){
	$WHERE .= "AND $search_field LIKE '%$search_value%'";
	}


	if($gd_id){

	$result = sql_query("SELECT COUNT(*) AS count FROM tt_tag a, tt_tag_item b, tt_goods_tag_cell_his c, tt_member e WHERE a.ta_id = b.ta_id AND b.ti_serial = c.ti_id AND c.mb_id = e.mb_id  $WHERE");
	$row = sql_fetch_array($result);
	$count = $row['count'];



	//echo "SELECT COUNT(*) AS count FROM tt_tag a, tt_tag_item b, tt_goods_tag_cell_his c, tt_member e WHERE a.ta_id = b.ta_id AND b.ti_serial = c.ti_id AND c.mb_id = e.mb_id  $WHERE";



	$limit = $limit;
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		

	$sql = "SELECT 
				a.ta_price, a.regdate AS regdate_tag , b.ti_percent , c.regdate AS regdate_cell, c.* , e.mb_name
			FROM 
				tt_tag a, tt_tag_item b, tt_goods_tag_cell_his c, tt_member e WHERE a.ta_id = b.ta_id AND b.ti_serial = c.ti_id AND c.mb_id = e.mb_id  $WHERE ORDER BY c.regdate desc, $sidx $sord LIMIT $start , $limit";
	$result = sql_query( $sql );

	//echo $sql;


	@$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['tc_no'];

		$status = $row['is_open'];

		//$STATUAS = $ARR_STATUS[$status];

		$responce->rows[$i]['cell']=array($row['tc_no'],$row['seq'],$row['regdate_cell'],$row['mb_id'],$status,$row['ti_percent'],$row['ta_price'],$row['start'],$row['choose'],$row['seq'],$row['pass']);
		$i++;
	
	}     
	
}
	echo json_encode($responce);



?>
